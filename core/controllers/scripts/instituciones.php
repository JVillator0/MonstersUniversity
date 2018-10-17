<?php  
//verifica si le han enviado una accion
if(isset($_GET["accion"])){
    //si es asi, manda a llamar la conexion, el validador de datos y el modelo.
    require_once("../../helpers/php/conexion.class.php");
    require_once("../../helpers/php/validator.class.php");
    require_once("../../models/instituciones.class.php");
    //instanciando el modelo
    $cls_instituciones = new cls_instituciones;
    //arreglo con el cual se retornaran los datos a la peticion ajax
    $retornar = array();
    //swith para gestionar las acciones
    switch ($_GET["accion"]) {
        case "seleccionar":
            $retornar["registros"] = $cls_instituciones->seleccionar();
        break;
        
        case "insertar":
            //validamos los datos
            $cls_instituciones->validateForm($_POST);
            $cls_instituciones->validateXSS($_POST);
            if($cls_instituciones->setInstitucion($_POST["institucion"])){   
                $cls_instituciones->setEstado(1);
                //ejecutamos la accion
                $retornar["resultado"] = $cls_instituciones->insertar();
            }else{
                $retornar["mensaje"] = "Institucion no valida.";
                $retornar["resultado"] = false;
            }
        break;
        
        case "editar":
            //validamos los datos
            $cls_instituciones->validateForm($_POST);
            $cls_instituciones->validateXSS($_POST);
            if($cls_instituciones->setId_institucion($_POST["id_institucion"])){
                if($cls_instituciones->setInstitucion($_POST["e_institucion"])){
                    //ejecutamos la accion
                    $retornar["resultado"] = $cls_instituciones->editar();
                }else{
                    $retornar["mensaje"] = "Institucion no valida.";
                    $retornar["resultado"] = false;
                }
            }else{
                $retornar["mensaje"] = "Id de institucion no valido.";
                $retornar["resultado"] = false;
            }
        break;
        
        case "eliminar":
            //validamos los datos
            $cls_instituciones->validateForm($_POST);
            $cls_instituciones->validateXSS($_POST);
            if($cls_instituciones->setId_institucion($_POST["id_institucion"])){
                $cls_instituciones->setEstado(0);
                //ejecutamos la accion
                $retornar["resultado"] = $cls_instituciones->eliminar();
            }else{
                $retornar["mensaje"] = "Id de institucion no valido.";
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