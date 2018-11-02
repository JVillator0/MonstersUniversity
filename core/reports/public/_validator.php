<?php 
//setea el metodo que pasara antes de ocurrir errores
set_error_handler("exceptions_error_handler");
//si hay errores se ejecuta, obteniendo las variables de los errores
function exceptions_error_handler($severity, $message, $filename, $lineno) {
    //si no hay ningun error no pasa nada, le retornar nada y la funcion termina en esta linea
    if(error_reporting() == 0) {  return; }
    if (error_reporting() & $severity) {
        //le decimos a donde redireccionara si algo no funciona
        $ruta = "../../../pages/public/index.php";
        header("location:" . $ruta);
    }
}
?>