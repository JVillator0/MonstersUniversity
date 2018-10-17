<?php
class cls_conexion
{
    //variables a utilizar en la conexion
    private $servidor = "localhost";
    private $usuario = "root";
    private $clave = "";
    private $database = "monsters_university_db";
    private $charset_db = "UTF8";

    //variable que almacena los errores con la conexion en caso ocurran
    private $error = array();

    //get de la variable privada donde se almacenan los errores con la conexion
    public function getError(){
        return $this->error;
    }

    public function conectar(){
        try{
            //estableciendo conexion, especificando que el servidor, el nombre de la base de datos
            //que queremos codificación UTF8, para poder ver tildes y enies en las consultas
            //tambien especificamos el usuario del gestor de base de datos con su respectiva clave
            $conexion = new PDO("mysql:host=".$this->servidor.";dbname=".$this->database.";charset=".$this->charset_db, $this->usuario, $this->clave);
            //si no ocurrio ningun error, devolvemos la conexion
            return $conexion;
        }catch(PDOException $e){
            //si ocurrio un error, guardamos los errores en una variable
            $this->error = $e->getCode();
        }
    }
}
?>