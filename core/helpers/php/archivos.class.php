<?php
class Clss_Archivos
{
    function __construct(){

    }

    //variables de la clase - atributos 

    private $file = null;
    private $permitidos = null;
    private $maximo_kb = null;
    private $ruta = null;
    private $nombre = null;
    private $width_perm = null;
    private $height_perm = null;

    //metodos de la clase - propiedades

    public function setFile($file){
        $this->file = $file;
    }

    public function setPermitidos($permitidos){
        $this->permitidos = $permitidos;
    }

    public function setMaximo_kb($maximo_kb){
        $this->maximo_kb = $maximo_kb;
    }

    public function setRuta($ruta){
        $this->ruta = $ruta;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setWidth_perm($width_perm){
        $this->width_perm = $width_perm;
    }

    public function setHeight_perm($height_perm){
        $this->height_perm = $height_perm;
    }

    //tomando en cuenta los atributos de la clase verifica que el $_FILE cumpla con los parametros
    public function validar(){
        $respuesta = array();
        //verifica que el archivo no tenga ningun error
        if ($this->file["error"] > 0) {
            $respuesta["mensaje"] = "El archivo contiene errores o es corrupto.";
            $respuesta["resultado"] = false;
        } else {
            //obtengo la informacion del archivo
            $info = new SplFileInfo($this->file["name"]);
            //obtengo la extension del mismo
            $extencion = $info->getExtension();
            //verifico si esta dentro de los permitods
            if(in_array($extencion, $this->permitidos)) {
                //verifico si el tamanio del archivo es menor o igual al permitido
                if ($this->file["size"] <= $this->maximo_kb) {
                    //verifico que las dimensiones de la imagen sean las permitidas
                    list($width, $height, $type) = getimagesize($this->file["tmp_name"]);
                    if($width == $this->height_perm && $height == $this->width_perm){
                        $respuesta["resultado"] = true;
                    }else{
                        $respuesta['mensaje'] = "Dimensiones de la imagen no permitidas, deben de ser de $width por $height.";
                        $respuesta["resultado"] = false;
                    }
                } else {
                    $respuesta['mensaje'] = "El archivo sobrepasa el limite de tamaño, deben de ser $this->maximo_kb kb como máximo.";
                    $respuesta["resultado"] = false;
                }
            } else {
                $respuesta['mensaje'] = "Extensión del archivo no permitida.";
                $respuesta["resultado"] = false;
            }
        }
        return $respuesta;
    }

    //sube el file anteriormente verificado, cambiando su nombre
    public function subir(){
        $respuesta = array();

        //obtengo la extension del archivo
        $info = new SplFileInfo($this->file["name"]);
        $extencion = $info->getExtension();

        //concateno el nuevo nombre con la extension y tambien la ruta donde se guardara
        $nombre_imagen = $this->nombre . "." . $extencion;
        $ruta_archivo = $this->ruta . $nombre_imagen;
        
        //si no existe ningun archivo con ese nombre....
        if (!file_exists($ruta_archivo)) {
            //subiendo el archivo y guardando el resultado en una variable
            $subido = move_uploaded_file($this->file["tmp_name"], $ruta_archivo);
            //devolviendo valores segun el resultado de la operacion
            if($subido){
                $respuesta["resultado"] = true;
                $respuesta["mensaje"] = $nombre_imagen;
            }else {
                $respuesta["resultado"] = false;
                $respuesta["mensaje"] = "Ocurrió un error al subir el archivo";
            }
        } else {
            $respuesta["resultado"] = false;
            $respuesta["mensaje"] = "Ya existe un archivo con el mismo nombre";
        }
        return $respuesta;
    }

    //comprueba si un fichero existe y si es asi lo elimina
    public function archivo_existente(){
        $respuesta = array();
        //obtiene la informacion del archivo
        $info = new SplFileInfo($this->file["name"]);
        //obtiene la extension
        $extencion = $info->getExtension();
        //concateno el nombre y la extension para saber que archivo y tambien la ruta del archivo
        $nombre_imagen = $this->nombre . "." . $extencion;
        $ruta_archivo = $this->ruta . $nombre_imagen;
        //si el archivo existe
        if (file_exists($ruta_archivo)) {
            //doy permisos para eliminar archivos
            chmod($ruta_archivo, 0777);
            //elimino el archivo
            if(unlink($ruta_archivo)){
                $respuesta["resultado"] = true;
            } else {
                $respuesta["resultado"] = false;
                $respuesta["mensaje"] = "Ocurrió un error al eliminar el archivo";
            }
        }else{
            $respuesta["resultado"] = true;
            $respuesta["mensaje"] = "No es posible eliminar el archivo porque no existe.";
        }
        return $respuesta;
    }

    //elimina la imagen, dando permisos para eliminar con "chmod($this->ruta, 0777);"
    public function eliminar(){
        //si el archivo existe
        if(is_file($this->ruta)){
            //doy permisos para eliminar archivos
            chmod($this->ruta, 0777);
            //elimino el archivo y devuelvo el resultado
            return unlink($this->ruta);
        }
    }
}
?>