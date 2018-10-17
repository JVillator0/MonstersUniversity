<?php  
//verifica si le han enviado una accion
if(isset($_GET["accion"])){
    //si es asi, manda a llamar la conexion, el validador de datos y el modelo.
    require_once("../../helpers/php/conexion.class.php");
    require_once("../../helpers/php/validator.class.php");
    require_once("../../models/usuarios.class.php");
    //instanciando el modelo
    $cls_usuarios = new cls_usuarios;
    //arreglo con el cual se retornaran los datos a la peticion ajax
    $retornar = array();
    //swith para gestionar las acciones
    switch ($_GET["accion"]) {
        case "seleccionar":

        break;
        
        default:
            
            break;
    }

    header("Content-type: application/json");
    echo json_encode($retornar);
}
?>