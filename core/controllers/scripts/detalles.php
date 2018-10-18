<?php  
//verifica si le han enviado una accion
if(isset($_GET["accion"])){
    //si es asi, manda a llamar la conexion, el validador de datos y el modelo.
    require_once("../../helpers/php/conexion.class.php");
    require_once("../../helpers/php/validator.class.php");
    require_once("../../models/detalles.class.php");
    //instanciando el modelo
    $cls_detalles = new cls_detalles;
    //arreglo con el cual se retornaran los datos a la peticion ajax
    $retornar = array();
    //swith para gestionar las acciones
    switch ($_GET["accion"]) {
        case "seleccionar":  
            $cls_detalles->setEstado($_POST["estado"]);
            $retornar["registros"] = $cls_detalles->seleccionar();
        break;

        case "seleccionar_inners":  
            $retornar["registros"] = $cls_detalles->seleccionar_inners();
        break;

        case "contar_solicitudes_x_estado":  
            $retornar["registros"] = $cls_detalles->contar_solicitudes_x_estado();
        break;

        case "contar_postulantes_x_carrera":  
            $retornar["registros"] = $cls_detalles->contar_postulantes_x_carrera();
        break;
        
        case "seleccionar_especifico":
            //se setea la id del postulante del cual pediremos informacion
            if($cls_detalles->setId_postulante($_POST["id_postulante"])){   
                $retornar["registros"] = $cls_detalles->seleccionar_especifico();
            }else{
                $retornar["mensaje"] = "Id postulante no valida.";
                $retornar["resultado"] = false;
            }
        break;
        
        case "seleccionar_online":
            if(session_status() == PHP_SESSION_NONE){     
                session_start(); 
            }
            //verifica si esta seteado el info_usuario en SESSION
            $retornar["resultado"] = isset($_SESSION["info_postulante"]);
            if($retornar["resultado"]){
                //se setea la id del postulante del cual pediremos informacion, es decir, el que este en linea
                if($cls_detalles->setId_postulante($_SESSION["info_postulante"][0]["Id_Postulante"])){   
                    $retornar["registros"] = $cls_detalles->seleccionar_especifico();
                }else{
                    $retornar["mensaje"] = "Id postulante no valida.";
                    $retornar["resultado"] = false;
                }
            }
        break;
        
        case "insertar":
            //mandamos a llamar el modelo para archivos
            require_once("../../helpers/php/archivos.class.php");
            //lo instanciamos
            $archivos = new Clss_Archivos();
            //seteamos el archivo, el $_FILE
            $archivos->setFile($_FILES["fl_imagen"]);
            //especificamos las extensiones que queremos
            $archivos->setPermitidos(["jpg", "jpeg", "png"]);
            //especificamos el maximo de kylobytes
            $archivos->setMaximo_kb(2097152);
            //especificamos el width y height permitidos
            $archivos->setWidth_perm(472);
            $archivos->setHeight_perm(472);
            //validamos la imagen, devuelve boolean y un mensaje
            $resp_validar = $archivos->validar();
            //si la imagen es valida....
            if($resp_validar["resultado"]){
                if(session_status() == PHP_SESSION_NONE){     
                    session_start(); 
                }
                //comenzamos con el insert en la tabla de detalles
                //validamos los campos
                $cls_detalles->validateForm($_POST);
                $cls_detalles->validateXSS($_POST);
                if($cls_detalles->setId_postulante($_SESSION["info_postulante"][0]["Id_Postulante"])){
                    if($cls_detalles->setId_institucion_procedencia($_POST["cmb_instituciones"])){
                        if($cls_detalles->setId_especialidad($_POST["cmb_especialidades"])){
                            if($cls_detalles->setAnio_inicio_b($_POST["anio_inicio"])){
                                if($cls_detalles->setAnio_fin_b($_POST["anio_fin"])){
                                    //el anio de inicio no puede ser mayor al de finalizacion
                                    if($_POST["anio_inicio"] < $_POST["anio_fin"]){
                                        //esto es para verificar que almenos uno de los telefonos tenga que ser obligatorio
                                        if($cls_detalles->setTel_fijo($_POST["tel_fijo"]) || $cls_detalles->setTel_movil($_POST["tel_movil"])){
                                            $cls_detalles->setTel_fijo($_POST["tel_fijo"]);
                                            $cls_detalles->setTel_movil($_POST["tel_movil"]);
                                            if($cls_detalles->setFecha_nacimiento($_POST["fecha_nacimiento"])){
                                                if($cls_detalles->setDui($_POST["dui"])){
                                                    if($cls_detalles->setNit($_POST["nit"])){
                                                        if($cls_detalles->setId_carrera($_POST["cmb_carreras"])){
                                                            //imagen por defecto
                                                            $cls_detalles->setImagen("notFound.jpg");
                                                            $cls_detalles->setEstado(1);
                                                            //realizamos la operacion
                                                            $retornar["resultado"] = $cls_detalles->insertar();
                                                        }else{
                                                            $retornar["mensaje"] = "Carrera no valida.";
                                                            $retornar["resultado"] = false;
                                                        }
                                                    }else{
                                                        $retornar["mensaje"] = "NIT no valido.";
                                                        $retornar["resultado"] = false;
                                                    }
                                                }else{
                                                    $retornar["mensaje"] = "DUI no valido.";
                                                    $retornar["resultado"] = false;
                                                }
                                            }else{
                                                $retornar["mensaje"] = "Fecha de nacimiento no valida.";
                                                $retornar["resultado"] = false;
                                            }
                                        }else{
                                            $retornar["mensaje"] = "Debe rellenar almenos un teléfono para realizar la operación.";
                                            $retornar["resultado"] = false;
                                        }
                                    }else{
                                        $retornar["mensaje"] = "El año de inicio del bachillerato debe ser menor al año de finalización.";
                                        $retornar["resultado"] = false;
                                    }
                                }else{
                                    $retornar["mensaje"] = "Año de finalización no valido.";
                                    $retornar["resultado"] = false;
                                }
                            }else{
                                $retornar["mensaje"] = "Año de inicio no valido.";
                                $retornar["resultado"] = false;
                            }
                        }else{
                            $retornar["mensaje"] = "Especialidad no valida.";
                            $retornar["resultado"] = false;
                        }
                    }else{
                        $retornar["mensaje"] = "Institución de procedencia no valida.";
                        $retornar["resultado"] = false;
                    }
                }else{
                    $retornar["mensaje"] = "Id de postulante no valido.";
                    $retornar["resultado"] = false;
                }
            }else{
                $retornar["mensaje"] = $resp_validar["mensaje"];
                $retornar["resultado"] = false;
            }
            
            //si se inserto correctamente el registro
            if($retornar["resultado"]){
                //obtenemos la id del registro recien insertado
                $id_detalle = $cls_detalles->getId_detalle_postulante();
                //especificamos la ruta donde se guardara la imagen
                $archivos->setRuta("../../../resource/img/postulantes/");
                //especificamos el nombre de la imagen al subirla
                $archivos->setNombre($id_detalle);
                //la subumos, devuelve boolean y un mensaje
                $resp_subir = $archivos->subir();
                if($resp_subir["resultado"]){
                    //mensaje contiene el nombre de la imagen subida
                    $nombre_imagen = $resp_subir["mensaje"];
                    //abrimos la conexion y seteamos el nuevo nombre de imagen
                    $cls_detalles->abrirConexion();
                    $cls_detalles->setImagen($nombre_imagen);
                    //editamos el registro para que tenga la imagen real
                    $retornar["resultado"] = $cls_detalles->editar();
                }else{
                    $retornar["mensaje"] = $resp_subir["mensaje"];
                    $retornar["resultado"] = false;
                }
            }
        break;
        
        case "editar":
            if($_FILES["fl_imagen"]["name"] != ""){
                //mandamos a llamar el modelo para archivos
                require_once("../../helpers/php/archivos.class.php");
                //lo instanciamos
                $archivos = new Clss_Archivos();
                //seteamos el archivo, el $_FILE
                $archivos->setFile($_FILES["fl_imagen"]);
                //especificamos las extensiones que queremos
                $archivos->setPermitidos(["jpg", "jpeg", "png"]);
                //especificamos el maximo de kylobytes
                $archivos->setMaximo_kb(2097152);
                //especificamos el width y height permitidos
                $archivos->setWidth_perm(472);
                $archivos->setHeight_perm(472);
                //validamos la imagen, devuelve boolean y un mensaje
                $resp_validar = $archivos->validar();
                //si la imagen es valida....
                if($resp_validar["resultado"]){
                    $archivos->setRuta("../../../resource/img/postulantes/" . $_POST['imagen']);
                    $resp_eliminar = $archivos->eliminar();
                    if(!$resp_eliminar['resultado']){
                        //especificamos la ruta donde se guardara la imagen
                        $archivos->setRuta("../../../resource/img/postulantes/");
                        //especificamos el nombre de la imagen al subirla
                        $archivos->setNombre($_POST["id_detalle_postulante"]);
                        //la subumos, devuelve boolean y un mensaje
                        $resp_subir = $archivos->subir();
                        if($resp_subir["resultado"]){
                            //mensaje contiene el nombre de la imagen subida
                            $nombre_imagen = $resp_subir["mensaje"];
                            //abrimos la conexion y seteamos el nuevo nombre de imagen
                            $cls_detalles->setImagen($nombre_imagen);
                            $retornar['resultado'] = true;
                        }else{
                            $retornar["mensaje"] = $resp_subir["mensaje"];
                            $retornar["resultado"] = false;
                        }
                    }else{
                        $retornar['mensaje'] = $resp_eliminar['mensaje'];
                        $retornar['resultado'] = false;
                    }
                }else{
                    $retornar["mensaje"] = $resp_validar["mensaje"];
                    $retornar["resultado"] = false;
                }
            }else{
                $cls_detalles->setImagen($_POST['imagen']);
                $retornar["resultado"] = true;
            }

            if($retornar["resultado"]){
                if(session_status() == PHP_SESSION_NONE){     
                    session_start(); 
                }
                //comenzamos con el insert en la tabla de detalles
                //validamos los campos
                $cls_detalles->validateForm($_POST);
                $cls_detalles->validateXSS($_POST);
                if($cls_detalles->setId_detalle_postulante($_POST["id_detalle_postulante"])){
                    if($cls_detalles->setId_postulante($_SESSION["info_postulante"][0]["Id_Postulante"])){
                        if($cls_detalles->setId_institucion_procedencia($_POST["cmb_instituciones"])){
                            if($cls_detalles->setId_especialidad($_POST["cmb_especialidades"])){
                                if($cls_detalles->setAnio_inicio_b($_POST["anio_inicio"])){
                                    if($cls_detalles->setAnio_fin_b($_POST["anio_fin"])){
                                        //el anio de inicio no puede ser mayor al de finalizacion
                                        if($_POST["anio_inicio"] < $_POST["anio_fin"]){
                                            //esto es para verificar que almenos uno de los telefonos tenga que ser obligatorio
                                            if($cls_detalles->setTel_fijo($_POST["tel_fijo"]) || $cls_detalles->setTel_movil($_POST["tel_movil"])){
                                                $cls_detalles->setTel_fijo($_POST["tel_fijo"]);
                                                $cls_detalles->setTel_movil($_POST["tel_movil"]);
                                                if($cls_detalles->setFecha_nacimiento($_POST["fecha_nacimiento"])){
                                                    if($cls_detalles->setDui($_POST["dui"])){
                                                        if($cls_detalles->setNit($_POST["nit"])){
                                                            if($cls_detalles->setId_carrera($_POST["cmb_carreras"])){
                                                                //realizamos la operacion
                                                                $retornar["resultado"] = $cls_detalles->editar();
                                                            }else{
                                                                $retornar["mensaje"] = "Carrera no valida.";
                                                                $retornar["resultado"] = false;
                                                            }
                                                        }else{
                                                            $retornar["mensaje"] = "NIT no valido.";
                                                            $retornar["resultado"] = false;
                                                        }
                                                    }else{
                                                        $retornar["mensaje"] = "DUI no valido.";
                                                        $retornar["resultado"] = false;
                                                    }
                                                }else{
                                                    $retornar["mensaje"] = "Fecha de nacimiento no valida.";
                                                    $retornar["resultado"] = false;
                                                }
                                            }else{
                                                $retornar["mensaje"] = "Debe ingresar almenos un teléfono para realizar la operación.";
                                                $retornar["resultado"] = false;
                                            }
                                        }else{
                                            $retornar["mensaje"] = "El año de inicio del bachillerato debe ser menor al año de finalización.";
                                            $retornar["resultado"] = false;
                                        }
                                    }else{
                                        $retornar["mensaje"] = "Año de finalización no valido.";
                                        $retornar["resultado"] = false;
                                    }
                                }else{
                                    $retornar["mensaje"] = "Año de inicio no valido.";
                                    $retornar["resultado"] = false;
                                }
                            }else{
                                $retornar["mensaje"] = "Especialidad no valida.";
                                $retornar["resultado"] = false;
                            }
                        }else{
                            $retornar["mensaje"] = "Institución de procedencia no valida.";
                            $retornar["resultado"] = false;
                        }
                    }else{
                        $retornar["mensaje"] = "Id de postulante no valido.";
                        $retornar["resultado"] = false;
                    }
                }else{
                    $retornar["mensaje"] = "Id del detalle del postulante no valido.";
                    $retornar["resultado"] = false;
                }
            }
        break;
        
        case "eliminar":
            //validamos los datos
            $cls_detalles->validateForm($_POST);
            $cls_detalles->validateXSS($_POST);
            if($cls_detalles->setId_detalle_postulante($_POST["id_detalle_postulante"])){   
                $cls_detalles->setEstado(0);
                //ejecutamos la accion
                $retornar["resultado"] = $cls_detalles->eliminar();
            }else{
                $retornar["mensaje"] = "Id de postulante no valido.";
                $retornar["resultado"] = false;
            }
        break;
        
        default:
            
            break;
    }

    //especificamos que la aplicacion devolvera contenido JSON
    header("Content-type: application/json");
    //imprimimos el arreglo en formato JSON
    echo json_encode($retornar);
}
?>