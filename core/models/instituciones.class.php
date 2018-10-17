<?php 

class cls_instituciones extends cls_validator
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
    private $id_institucion_procedencia = null;
    private $institucion_procedencia = null;
    private $estado = null;

    //setters de los atributos
    public function setId_institucion($id_institucion_procedencia){
        if($this->validateId($id_institucion_procedencia)){
			$this->id_institucion_procedencia = $id_institucion_procedencia;
			return true;
		}else{
			return false;
		}
    }

    public function setInstitucion($institucion_procedencia){
        if($this->validateAlphabetic($institucion_procedencia, 1, 200)){
			$this->institucion_procedencia = $institucion_procedencia;
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
        $sql = "SELECT * FROM institucion_procedencia IP WHERE IP.Estado = 1;";
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
        $sql = "INSERT INTO institucion_procedencia (Institucion_Procedencia, Estado) VALUES (?, ?);";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->institucion_procedencia);
        $query->bindParam(2, $this->estado);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function editar(){
        //sql de la consulta
        $sql = "UPDATE institucion_procedencia SET Institucion_Procedencia = ? WHERE Id_Institucion_Procedencia = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->institucion_procedencia);
        $query->bindParam(2, $this->id_institucion_procedencia);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function eliminar(){
        //sql de la consulta
        $sql = "UPDATE institucion_procedencia SET Estado = ? WHERE Id_Institucion_Procedencia = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->estado);
        $query->bindParam(2, $this->id_institucion_procedencia);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }
}

?>