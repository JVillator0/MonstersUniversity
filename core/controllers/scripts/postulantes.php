<?php  
//verifica si le han enviado una accion
if(isset($_GET["accion"])){
    //si es asi, manda a llamar la conexion, el validador de datos y el modelo.
    require_once("../../helpers/php/conexion.class.php");
    require_once("../../helpers/php/validator.class.php");
    require_once("../../models/postulantes.class.php");
    //instanciando el modelo
    $cls_postulantes = new cls_postulantes;
    //arreglo con el cual se retornaran los datos a la peticion ajax
    $retornar = array();
    //swith para gestionar las acciones
    switch ($_GET["accion"]) {
        case "seleccionar":
            $retornar["registros"] = $cls_postulantes->seleccionar();
        break;
        
        case "insertar":
            //validamos los datos
            $cls_postulantes->validateForm($_POST);
            $cls_postulantes->validateXSS($_POST);
            if($cls_postulantes->setNombres($_POST["nombres"])){   
                if($cls_postulantes->setApellidos($_POST["apellidos"])){
                    if($cls_postulantes->setCorreo($_POST["correo"])){
                        //la confirmacion de clave es correcta?
                        if($_POST["clave"] == $_POST["confirmar"]){
                            if($cls_postulantes->setClave($_POST["clave"])){
                                $cls_postulantes->setEstado(1);
                                //ejecutamos la accion
                                $retornar["resultado"] = $cls_postulantes->insertar();
                            }else{
                                $retornar["mensaje"] = "Clave no valida.
                                \nDebe contener minomo 8 caracteres.
                                \nDebe contener mayusculas y minusculas.
                                \nDebe contener almenos un caracter especial.";
                                $retornar["resultado"] = false;
                            }
                        }else{
                            $retornar["mensaje"] = "Las claves no son iguales.";
                            $retornar["resultado"] = false;
                        }
                    }else{
                        $retornar["mensaje"] = "Correo no valido.";
                        $retornar["resultado"] = false;
                    }
                }else{
                    $retornar["mensaje"] = "Apellidos no validos.";
                    $retornar["resultado"] = false;
                }
            }else{
                $retornar["mensaje"] = "Nombres no validos.";
                $retornar["resultado"] = false;
            }
        break;

        case "iniciar":
            if(session_status() == PHP_SESSION_NONE){     
                session_start(); 
            }
            //validamos los datos
            $cls_postulantes->validateForm($_POST);
            $cls_postulantes->validateXSS($_POST);
            if($cls_postulantes->setId_Postulante($_SESSION["info_postulante"][0]["Id_Postulante"])){
                $cls_postulantes->setEstado(2);
                //ejecutamos la accion
                $retornar["resultado"] = $cls_postulantes->cambiar_estado();
            }else{
                $retornar["mensaje"] = "Id de postulante no valido.";
                $retornar["resultado"] = false;
            }
        break;

        case "finalizar":
            if(session_status() == PHP_SESSION_NONE){     
                session_start(); 
            }
            //validamos los datos
            $cls_postulantes->validateForm($_POST);
            $cls_postulantes->validateXSS($_POST);
            if($cls_postulantes->setId_Postulante($_SESSION["info_postulante"][0]["Id_Postulante"])){
                $cls_postulantes->setEstado(3);
                //ejecutamos la accion
                $retornar["resultado"] = $cls_postulantes->cambiar_estado();
            }else{
                $retornar["mensaje"] = "Id de postulante no valido.";
                $retornar["resultado"] = false;
            }
        break;

        case "editar_perfil":
            if(session_status() == PHP_SESSION_NONE){     
                session_start(); 
            }
            //validamos los datos
            $cls_postulantes->validateForm($_POST);
            $cls_postulantes->validateXSS($_POST);
            if($cls_postulantes->setId_Postulante($_SESSION["info_postulante"][0]["Id_Postulante"])){
                if($cls_postulantes->setNombres($_POST["e_nombres"])){
                    if($cls_postulantes->setApellidos($_POST["e_apellidos"])){
                        if($cls_postulantes->setCorreo($_POST["e_correo"])){
                            //ejecutamos la accion
                            $retornar["resultado"] = $cls_postulantes->editar();
                            if($retornar["resultado"]){
                                //rellenamos denuevo la variable de sesion
                                $retornar["registro"] = $cls_postulantes->login();
                                $_SESSION["info_postulante"] = $retornar["registro"];
                            }
                        }else{
                            $retornar["mensaje"] = "Correo no valido.";
                            $retornar["resultado"] = false;
                        }
                    }else{
                        $retornar["mensaje"] = "Apellidos no validos.";
                        $retornar["resultado"] = false;
                    }
                }else{
                    $retornar["mensaje"] = "Nombres no validos.";
                    $retornar["resultado"] = false;
                }
            }else{
                $retornar["mensaje"] = "Id de postulante no valido.";
                $retornar["resultado"] = false;
            }
        break;

        case "editar_clave":
            if(session_status() == PHP_SESSION_NONE){     
                session_start(); 
            }
            //validamos los datos
            $cls_postulantes->validateForm($_POST);
            $cls_postulantes->validateXSS($_POST);
            $cls_postulantes->setCorreo($_SESSION["info_postulante"][0]["Correo"]);
            $retornar["registro"] = $cls_postulantes->login();
            //verificamos que la clave actual este correcta
            $retornar["resultado"] = password_verify($_POST["clave"], $retornar["registro"][0]["Clave"]);
            if($retornar["resultado"]){
                //la confirmacion de clave es correcta?
                if($_POST["nueva"] == $_POST["confirmar"]){
                    //la clave nueva cumple con los parametros?
                    if($cls_postulantes->setClave($_POST["nueva"])){
                        //especificamos la ID del usuario
                        $cls_postulantes->setId_Postulante($_SESSION["info_postulante"][0]["Id_Postulante"]);
                        //abrimos la conexion nuevamente
                        $cls_postulantes->abrirConexion();
                        //ejecutamos la accion
                        $retornar["resultado"] = $cls_postulantes->editar_clave();
                    }else{
                        $retornar["mensaje"] = "Clave no valida.
                        \nDebe contener minomo 8 caracteres.
                        \nDebe contener mayusculas y minusculas.
                        \nDebe contener almenos un caracter especial.";
                        $retornar["resultado"] = false;
                    }
                }else{
                    $retornar["mensaje"] = "Las claves no son iguales.";
                    $retornar["resultado"] = false;
                }
            }else{
                $retornar["mensaje"] = "Clave incorrecta";
                $retornar["resultado"] = false;
            }
        break;
        
        case "login":
            //validamos los datos
            $cls_postulantes->validateForm($_POST);
            $cls_postulantes->validateXSS($_POST);
            if($cls_postulantes->setCorreo($_POST["lg_correo"])){
                //obtenemos el registro con el correo ingresado
                $retornar["registro"] = $cls_postulantes->login();
                //vemos si devolvio registros
                if(count($retornar["registro"]) > 0){
                    //comparamos la clave escrita con la clave encriptada
                    $retornar["resultado"] = password_verify($_POST["lg_clave"], $retornar["registro"][0]["Clave"]);
                    if($retornar["resultado"]){
                        //si son correctas, llenamos la variable de sesion
                        if(session_status() == PHP_SESSION_NONE){     
                            session_start(); 
                        }
                        $_SESSION["info_postulante"] = $retornar["registro"];
                    }else{
                        $retornar["mensaje"] = "Clave incorrecta";
                        $retornar["resultado"] = false;
                    }
                }else{
                    $retornar["mensaje"] = "No se encontro ningun usuario.";
                    $return["resultado"] = false;
                }
            }else{
                $retornar["mensaje"] = "Correo no valido.";
                $retornar["resultado"] = false;
            }
        break;
        
        case "online":
            //inicia la sesion
            if(session_status() == PHP_SESSION_NONE){     
                session_start(); 
            }
            //verifica si esta seteado el info_usuario en SESSION
            $retornar["resultado"] = isset($_SESSION["info_postulante"]);
            if($retornar["resultado"]){
                //si es asi, devuelve la info del usuario
                $retornar["registro"] = $_SESSION["info_postulante"][0];
            }else{
                $retornar["mensaje"] = "Debe iniciar sesión.";
                $retornar["resultado"] = false;
            }
        break;

        case "destroy":
            //inicia la sesion
            session_start(); 
            //la des-setea
            unset($_SESSION["info_postulante"]);
        break;

        case "restaurar_enviar_email":
            //validamos los datos
            $cls_postulantes->validateForm($_POST);
            $cls_postulantes->validateXSS($_POST);
            if($cls_postulantes->setCorreo($_POST["r_correo"])){
                //obtenemos el registro con el alias ingresado
                $resultado = $cls_postulantes->login();
                //vemos si devolvio registros
                if(count($resultado) > 0){
                    //para acceder mas facilmente al registro
                    $resultado = $resultado[0];
                    //seteamos la id del postulante que restaurara la clave
                    $retornar["id"] = $resultado["Id_Postulante"];
                    //mandamos a llamar el script para los correos
                    require_once("../../helpers/php/email.class.php");
                    $cls_email = new Clss_Email;
                    $cls_email->setSendAddress($resultado["Correo"]);
                    $cls_email->setSubject("Restaurar clave");
                    $cls_email->setIsHTML(true);
                    //seteamos el codigo que enviaremos
                    $retornar["codigo"] = $cls_email->generateRandomString(8);
                    //sera un email html asi que obtenemos el formato
                    $bodyDelEmail = file_get_contents("../../../resource/emails/restaurar.html");
                    //reemplazamos los nombres
                    $bodyDelEmail = str_replace("###NOMBRES###", $resultado["Nombres"] . " " . $resultado["Apellidos"], $bodyDelEmail);
                    //ponemos el codigo en el html que enviaremos
                    $bodyDelEmail = str_replace("###CODIGO###", $retornar["codigo"], $bodyDelEmail);
                    //seteamos el body del email
                    $cls_email->setBody($bodyDelEmail);
                    //enviamos el correo
                    $retornar["resultado"] = $cls_email->SendEmail();
                }else{
                    $retornar["mensaje"] = "No se encontro ningun usuario.";
                    $retornar["resultado"] = false;
                }
            }else{
                $retornar["mensaje"] = "Correo no valido.";
                $retornar["resultado"] = false;
            }
        break;

        case "restaurar":
            $cls_postulantes->validateForm($_POST);
            $cls_postulantes->validateXSS($_POST);
            if($_POST["r_clave"] == $_POST["r_confirmar"]){
                //la clave nueva cumple con los parametros?
                if($cls_postulantes->setClave($_POST["r_clave"])){
                    //especificamos la ID del usuario
                    $cls_postulantes->setId_postulante($_POST["id"]);
                    //abrimos la conexion nuevamente
                    $cls_postulantes->abrirConexion();
                    //ejecutamos la accion
                    $retornar["resultado"] = $cls_postulantes->editar_clave();
                }else{
                    $retornar["mensaje"] = "Clave no valida.
                    \nDebe contener minomo 8 caracteres.
                    \nDebe contener mayusculas y minusculas.
                    \nDebe contener almenos un caracter especial.";
                    $retornar["resultado"] = false;
                }
            }else{
                $retornar["mensaje"] = "Las claves no son iguales.";
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