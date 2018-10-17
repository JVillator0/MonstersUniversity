<?php 

class cls_especialidades extends cls_validator
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
    private $id_especialidad = null;
    private $especialidad = null;
    private $estado = null;

    //setters de los atributos
    public function setId_especialidad($id_especialidad){
        if($this->validateId($id_especialidad)){
			$this->id_especialidad = $id_especialidad;
			return true;
		}else{
			return false;
		}
    }

    public function setEspecialidad($especialidad){
        if($this->validateAlphabetic($especialidad, 1, 200)){
			$this->especialidad = $especialidad;
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
        $sql = "SELECT * FROM especialidad E WHERE E.Estado = 1;";
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
        $sql = "INSERT INTO especialidad (Especialidad, Estado) VALUES (?, ?);";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->especialidad);
        $query->bindParam(2, $this->estado);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function editar(){
        //sql de la consulta
        $sql = "UPDATE especialidad SET Especialidad = ? WHERE Id_Especialidad = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->especialidad);
        $query->bindParam(2, $this->id_especialidad);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function eliminar(){
        //sql de la consulta
        $sql = "UPDATE especialidad SET Estado = ? WHERE Id_Especialidad = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->estado);
        $query->bindParam(2, $this->id_especialidad);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }
}

?>