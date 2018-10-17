<?php 

class cls_usuarios extends cls_validator
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
    private $id_usuario = null;
    private $nombres = null;
    private $apellidos = null;
    private $correo = null;
    private $alias = null;
    private $clave = null;
    private $estado = null;
    private $usuario_online = null;

    //setters de los atributos
    public function setId_usuario($id_usuario){
        if($this->validateId($id_usuario)){
			$this->id_usuario = $id_usuario;
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

    public function setAlias($alias){
        if($this->validateAlphabetic($alias, 1, 200)){
            $this->alias = $alias;
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

    public function setEstado($estado){
        $this->estado = $estado;
    }

    //propiedades del modelo, los metodos
    public function seleccionar(){
        //sql de la consulta
        $sql = "SELECT * FROM usuario U WHERE U.Estado = 1;";
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
        $sql = "INSERT INTO usuario (Nombres, Apellidos, Correo, Alias, Clave, Estado) VALUES (?, ?, ?, ?, ?, ?);";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->nombres);
        $query->bindParam(2, $this->apellidos);
        $query->bindParam(3, $this->correo);
        $query->bindParam(4, $this->alias);
        $query->bindParam(5, $this->clave);
        $query->bindParam(6, $this->estado);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function editar(){
        //sql de la consulta
        $sql = "UPDATE usuario SET Nombres = ?, Apellidos = ?, Correo = ?, Alias = ? WHERE Id_Usuario = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->nombres);
        $query->bindParam(2, $this->apellidos);
        $query->bindParam(3, $this->correo);
        $query->bindParam(4, $this->alias);
        $query->bindParam(5, $this->id_usuario);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }
    
    public function editar_clave(){
        //sql de la consulta
        $sql = "UPDATE usuario SET Clave = ? WHERE Id_Usuario = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->clave);
        $query->bindParam(2, $this->id_usuario);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function eliminar(){
        //sql de la consulta
        $sql = "UPDATE usuario SET Estado = ? WHERE Id_Usuario = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->estado);
        $query->bindParam(2, $this->id_usuario);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function login(){
        //sql de la consulta
        $sql = "SELECT * FROM usuario U WHERE U.Alias = ? AND U.Estado = 1;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->alias);
        //ejecutando
        $query->execute();
        //obteniendo el resultado de la consulta
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->usuario_online = $result;
        $this->conexion = null;
        return $result;
    }

    public function getUsuario_online(){
        return $this->usuario_online;
    }
}

?>