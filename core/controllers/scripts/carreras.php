<?php  
//verifica si le han enviado una accion
if(isset($_GET["accion"])){
    //si es asi, manda a llamar la conexion, el validador de datos y el modelo.
    require_once("../../helpers/php/conexion.class.php");
    require_once("../../helpers/php/validator.class.php");
    require_once("../../models/carreras.class.php");
    //instanciando el modelo
    $cls_carreras = new cls_carreras;
    //arreglo con el cual se retornaran los datos a la peticion ajax
    $retornar = array();
    //swith para gestionar las acciones
    switch ($_GET["accion"]) {
        case "seleccionar":
            $retornar["registros"] = $cls_carreras->seleccionar();
        break;
        
        case "insertar":
            //validamos los datos
            $cls_carreras->validateForm($_POST);
            $cls_carreras->validateXSS($_POST);
            if($cls_carreras->setCarrera($_POST["carrera"])){   
                if($cls_carreras->setDescripcion($_POST["descripcion"])){   
                    $cls_carreras->setEstado(1);
                    //ejecutamos la accion
                    $retornar["resultado"] = $cls_carreras->insertar();
                }else{
                    $retornar["mensaje"] = "Descripción no valida.";
                    $retornar["resultado"] = false;
                }
            }else{
                $retornar["mensaje"] = "Carrera no valida.";
                $retornar["resultado"] = false;
            }
        break;
        
        case "editar":
            //validamos los datos
            $cls_carreras->validateForm($_POST);
            $cls_carreras->validateXSS($_POST);
            if($cls_carreras->setId_carrera($_POST["id_carrera"])){
                if($cls_carreras->setCarrera($_POST["e_carrera"])){
                    if($cls_carreras->setDescripcion($_POST["e_descripcion"])){   
                        //ejecutamos la accion
                        $retornar["resultado"] = $cls_carreras->editar();
                    }else{
                        $retornar["mensaje"] = "Descripción no valida.";
                        $retornar["resultado"] = false;
                    }
                }else{
                    $retornar["mensaje"] = "Carrera no valida.";
                    $retornar["resultado"] = false;
                }
            }else{
                $retornar["mensaje"] = "Id de carrera no valido.";
                $retornar["resultado"] = false;
            }
        break;
        
        case "eliminar":
            //validamos los datos
            $cls_carreras->validateForm($_POST);
            $cls_carreras->validateXSS($_POST);
            if($cls_carreras->setId_carrera($_POST["id_carrera"])){
                $cls_carreras->setEstado(0);
                //ejecutamos la accion
                $retornar["resultado"] = $cls_carreras->eliminar();
            }else{
                $retornar["mensaje"] = "Id de carrera no valido.";
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