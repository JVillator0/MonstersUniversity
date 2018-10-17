<?php
//verifica si se ha enviado una accion
if(isset($_GET['accion'])){
    //manda a llamar el modelo que controla codigos
    require_once('conexion.class.php');
    $class_obj = new Clss_Conexion();
    //array para retornar la respuesta al cliente
    $respuesta = array();
    //evalua la accion a realizar
    switch($_GET['accion']){
        //verifica si hay errores y los retorna en una posicion del arreglo en caso haya.
        case 'errores':
            $conexion = $class_obj->Conectar();
            $respuesta['errores'] = $class_obj->getError();
            $conexion = null;
        break;

        //retorna en una posicion del arreglo TRUE si hay mas de 0 errores con la conexion, FALSE si hay 0 errores.
        case 'errores_estado':
            $conexion = $class_obj->Conectar();
            $respuesta['estado'] = count($class_obj->getError()) > 0;
            $conexion = null;
        break;

        default:

        break;
    }
    //especificamos que este archivo PHP trabajara con JSON
    header("Content-type: application/json");
    //imprimi en formato JSON el arreglo, retornandolo a la peticion ajax
    echo json_encode($respuesta);
}
?>