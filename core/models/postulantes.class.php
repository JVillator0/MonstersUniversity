<?php 

class cls_postulantes extends cls_validator
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
    private $id_postulante = null;
    private $nombres = null;
    private $apellidos = null;
    private $correo = null;
    private $clave = null;
    private $estado = null;
    private $postulante_online = null;

    //setters de los atributos
    public function setId_postulante($id_postulante){
        if($this->validateId($id_postulante)){
			$this->id_postulante = $id_postulante;
			return true;
		}else{
			return false;
		}
    }

    public function setNombres($nombres){
        if($this->validateAlphabetic($nombres, 1, 200)){
			$this->nombres = $nombres;
			return true;
		}else{
			return false;
		}
    }

    public function setApellidos($apellidos){
        if($this->validateAlphabetic($apellidos, 1, 200)){
            $this->apellidos = $apellidos;
			return true;
		}else{
			return false;
		}
    }

    public function setCorreo($correo){
        if($this->validateEmail($correo)){
            $this->correo = $correo;
			return true;
		}else{
			return false;
		}
    }

    public function setClave($clave){
        if($this->validatePassword($clave)){
            $this->clave = password_hash($clave, PASSWORD_DEFAULT);
			return true;
		}else{
			return false;
		}
    }

    //1-Solo registrado
    //2-con solicitud registrada, SIN finalizar
    //3-con solicitud registrada, FINALIZADA
    public function setEstado($estado){
        $this->estado = $estado;
    }

    //propiedades del modelo, los metodos
    public function seleccionar(){
        //sql de la consulta
        $sql = "SELECT * FROM postulante P WHERE P.Estado != 0;";
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
        $sql = "INSERT INTO postulante (Nombres, Apellidos, Correo, Clave, Estado) VALUES (?, ?, ?, ?, ?);";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->nombres);
        $query->bindParam(2, $this->apellidos);
        $query->bindParam(3, $this->correo);
        $query->bindParam(4, $this->clave);
        $query->bindParam(5, $this->estado);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function editar(){
        //sql de la consulta
        $sql = "UPDATE postulante SET Nombres = ?, Apellidos = ?, Correo = ? WHERE Id_Postulante = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->nombres);
        $query->bindParam(2, $this->apellidos);
        $query->bindParam(3, $this->correo);
        $query->bindParam(4, $this->id_postulante);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }
    
    public function editar_clave(){
        //sql de la consulta
        $sql = "UPDATE postulante SET Clave = ? WHERE Id_Postulante = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->clave);
        $query->bindParam(2, $this->id_postulante);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function cambiar_estado(){
        //sql de la consulta
        $sql = "UPDATE postulante SET Estado = ? WHERE Id_Postulante = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->estado);
        $query->bindParam(2, $this->id_postulante);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function login(){
        //sql de la consulta
        $sql = "SELECT * FROM postulante P WHERE P.Correo = ? AND P.Estado != 0;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->correo);
        //ejecutando
        $query->execute();
        //obteniendo el resultado de la consulta
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->postulante_online = $result;
        $this->conexion = null;
        return $result;
    }

    public function getPostulante_online(){
        return $this->postulante_online;
    }
}

?>