<?php 

class cls_carreras extends cls_validator
{
    private $conexion = null;
    
    //constructor de la clase para abrir la conexion 
    function __construct(){
        $cls_conexion = new cls_conexion();
        $this->conexion = $cls_conexion->conectar();
    }

    //metodo auxiliar para abrir la conexion
    public function abrirConexion(){
        if($this->conexion == null){
            $cls_conexion = new cls_conexion();
            $this->conexion = $cls_conexion->conectar();
        }
    }

    //atributos del modelo
    private $id_carrera = null;
    private $carrera = null;
    private $descripcion = null;
    private $estado = null;

    //setters de los atributos
    public function setId_carrera($id_carrera){
        if($this->validateId($id_carrera)){
			$this->id_carrera = $id_carrera;
			return true;
		}else{
			return false;
		}
    }

    public function setCarrera($carrera){
        if($this->validateAlphabetic($carrera, 1, 200)){
			$this->carrera = $carrera;
			return true;
		}else{
			return false;
		}
    }

    public function setDescripcion($descripcion){
        if($this->validateAlphanumeric($descripcion, 1, 500)){
			$this->descripcion = $descripcion;
			return true;
		}else{
			return false;
		}
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

    //propiedades del modelo, los metodos
    public function seleccionar(){
        //sql de la consulta
        $sql = "SELECT * FROM carrera C WHERE C.Estado = 1;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //ejecutandola
        $query->execute();
        //obteniendo el resultado en un arreglo asociativo
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->conexion = null;
        return $result;
    }

    public function insertar(){
        //sql de la consulta
        $sql = "INSERT INTO carrera (Carrera, Descripcion, Estado) VALUES (?, ?, ?);";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->carrera);
        $query->bindParam(2, $this->descripcion);
        $query->bindParam(3, $this->estado);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function editar(){
        //sql de la consulta
        $sql = "UPDATE carrera SET Carrera = ?, Descripcion = ? WHERE Id_Carrera = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->carrera);
        $query->bindParam(2, $this->descripcion);
        $query->bindParam(3, $this->id_carrera);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function eliminar(){
        //sql de la consulta
        $sql = "UPDATE carrera SET Estado = ? WHERE Id_Carrera = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->estado);
        $query->bindParam(2, $this->id_carrera);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }
}

?>