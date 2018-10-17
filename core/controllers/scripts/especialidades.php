<?php  
//verifica si le han enviado una accion
if(isset($_GET["accion"])){
    //si es asi, manda a llamar la conexion, el validador de datos y el modelo.
    require_once("../../helpers/php/conexion.class.php");
    require_once("../../helpers/php/validator.class.php");
    require_once("../../models/especialidades.class.php");
    //instanciando el modelo
    $cls_especialidades = new cls_especialidades;
    //arreglo con el cual se retornaran los datos a la peticion ajax
    $retornar = array();
    //swith para gestionar las acciones
    switch ($_GET["accion"]) {
        case "seleccionar":
            $retornar["registros"] = $cls_especialidades->seleccionar();
        break;
        
        case "insertar":
            //validamos los datos
            $cls_especialidades->validateForm($_POST);
            $cls_especialidades->validateXSS($_POST);
            if($cls_especialidades->setEspecialidad($_POST["especialidad"])){   
                $cls_especialidades->setEstado(1);
                //ejecutamos la accion
                $retornar["resultado"] = $cls_especialidades->insertar();
            }else{
                $retornar["mensaje"] = "Especialidad no valida.";
                $retornar["resultado"] = false;
            }
        break;
        
        case "editar":
            //validamos los datos
            $cls_especialidades->validateForm($_POST);
            $cls_especialidades->validateXSS($_POST);
            if($cls_especialidades->setId_especialidad($_POST["id_especialidad"])){
                if($cls_especialidades->setEspecialidad($_POST["e_especialidad"])){
                    //ejecutamos la accion
                    $retornar["resultado"] = $cls_especialidades->editar();
                }else{
                    $retornar["mensaje"] = "Especialidad no valida.";
                    $retornar["resultado"] = false;
                }
            }else{
                $retornar["mensaje"] = "Id de especialidad no valido.";
                $retornar["resultado"] = false;
            }
        break;
        
        case "eliminar":
            //validamos los datos
            $cls_especialidades->validateForm($_POST);
            $cls_especialidades->validateXSS($_POST);
            if($cls_especialidades->setId_especialidad($_POST["id_especialidad"])){  
                $cls_especialidades->setEstado(0);
                //ejecutamos la accion
                $retornar["resultado"] = $cls_especialidades->eliminar();
            }else{
                $retornar["mensaje"] = "Id de especialidad no valido.";
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