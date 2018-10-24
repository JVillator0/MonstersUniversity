<?php 

class cls_detalles extends cls_validator
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
    private $id_detalle_postulante = null;
    private $id_postulante = null;
    private $id_institucion_procedencia = null;
    private $id_especialidad = null;
    private $anio_inicio_b = null;
    private $anio_fin_b = null;
    private $id_carrera = null;
    private $tel_fijo = null;
    private $tel_movil = null;
    private $fecha_nacimiento = null;
    private $dui = null;
    private $nit = null;
    private $imagen = null;
    private $estado = null;

    //setters de los atributos
    public function setId_detalle_postulante($id_detalle_postulante){
        if($this->validateId($id_detalle_postulante)){
			$this->id_detalle_postulante = $id_detalle_postulante;
			return true;
		}else{
			return false;
		}
    }
    
    public function getId_detalle_postulante(){
        return $this->id_detalle_postulante;
    }

    public function setId_postulante($id_postulante){
        if($this->validateId($id_postulante)){
			$this->id_postulante = $id_postulante;
			return true;
		}else{
			return false;
		}
    }
    
    public function setId_institucion_procedencia($id_institucion_procedencia){
        if($this->validateId($id_institucion_procedencia)){
			$this->id_institucion_procedencia = $id_institucion_procedencia;
			return true;
		}else{
			return false;
		}
    }
    
    public function setId_especialidad($id_especialidad){
        if($this->validateId($id_especialidad)){
			$this->id_especialidad = $id_especialidad;
			return true;
		}else{
			return false;
		}
    }

    public function setAnio_inicio_b($anio_inicio_b){
        if($this->validateStr($anio_inicio_b)){
            $this->anio_inicio_b = $anio_inicio_b;
			return true;
		}else{
			return false;
		}
    }

    public function setAnio_fin_b($anio_fin_b){
        if($this->validateStr($anio_fin_b)){
            $this->anio_fin_b = $anio_fin_b;
			return true;
		}else{
			return false;
		}
    }
    
    public function setId_carrera($id_carrera){
        if($this->validateId($id_carrera)){
			$this->id_carrera = $id_carrera;
			return true;
		}else{
			return false;
		}
    }
    
    public function setTel_fijo($tel_fijo){
        if($this->validateTelephone($tel_fijo)){
			$this->tel_fijo = $tel_fijo;
			return true;
		}else{
			return false;
		}
    }
    
    public function setTel_movil($tel_movil){
        if($this->validateTelephone($tel_movil)){
			$this->tel_movil = $tel_movil;
			return true;
		}else{
			return false;
		}
    }

    public function setFecha_nacimiento($fecha_nacimiento){
        if($this->validateDate($fecha_nacimiento)){
            $fecha = str_replace('/', '-', $fecha_nacimiento);
            $this->fecha_nacimiento = date('Y-m-d', strtotime($fecha));;
			return true;
		}else{
			return false;
		}
    }
    
    public function setDui($dui){
        if($this->validateDUI($dui)){
			$this->dui = $dui;
			return true;
		}else{
			return false;
		}
    }
    
    public function setNit($nit){
        if($this->validateNIT($nit)){
			$this->nit = $nit;
			return true;
		}else{
			return false;
		}
    }

    public function setImagen($imagen){
        $this->imagen = $imagen;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

    //propiedades del modelo, los metodos
    public function seleccionar(){
        //sql de la consulta, utilozo INNER JOIN porque necesito todos los datos de los postulantes, sean nulos o no
        $sql = "SELECT P.Id_Postulante, P.Nombres, P.Apellidos, DP.Id_Detalle_Postulante, DATE_FORMAT(DP.Fecha_Nacimiento, '%d/%m/%Y') AS Fecha_Nacimiento, 
        CONCAT(DP.Tel_Fijo, ' ' ,DP.Tel_Movil) AS Telefonos, DP.Tel_Fijo, DP.Tel_Movil, DP.DUI, DP.NIT, DP.Imagen, P.Correo, 
        IP.Id_Institucion_Procedencia, IP.Institucion_Procedencia, E.Id_Especialidad, E.Especialidad, 
        DP.Anio_Inicio_B, DP.Anio_Fin_B, C.Id_Carrera, C.Carrera, C.Descripcion, P.Estado
        FROM postulante P
        INNER JOIN detalle_postulante DP ON DP.Id_Postulante = P.Id_Postulante
        INNER JOIN institucion_procedencia IP ON DP.Id_Institucion_Procedencia = IP.Id_Institucion_Procedencia
        INNER JOIN especialidad E ON DP.Id_Especialidad = E.Id_Especialidad
        INNER JOIN carrera C ON DP.Id_Carrera = C.Id_Carrera
        AND P.Estado = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->estado);
        //ejecutandola
        $query->execute();
        //obteniendo el resultado en un arreglo asociativo
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->conexion = null;
        return $result;
    }

    public function seleccionar_inners(){
        //sql de la consulta, utilozo INNER JOIN porque necesito todos los datos de los postulantes, sean nulos o no
        $sql = "SELECT P.Id_Postulante, P.Nombres, P.Apellidos, DP.Id_Detalle_Postulante, DATE_FORMAT(DP.Fecha_Nacimiento, '%d/%m/%Y') AS Fecha_Nacimiento, 
        CONCAT(DP.Tel_Fijo, ', ' ,DP.Tel_Movil) AS Telefonos, DP.Tel_Fijo, DP.Tel_Movil, DP.DUI, DP.NIT, DP.Imagen, P.Correo, 
        IP.Id_Institucion_Procedencia, IP.Institucion_Procedencia, E.Id_Especialidad, E.Especialidad, 
        DP.Anio_Inicio_B, DP.Anio_Fin_B, C.Id_Carrera, C.Carrera, C.Descripcion, P.Estado
        FROM postulante P
        INNER JOIN detalle_postulante DP ON DP.Id_Postulante = P.Id_Postulante
        INNER JOIN institucion_procedencia IP ON DP.Id_Institucion_Procedencia = IP.Id_Institucion_Procedencia
        INNER JOIN especialidad E ON DP.Id_Especialidad = E.Id_Especialidad
        INNER JOIN carrera C ON DP.Id_Carrera = C.Id_Carrera
        AND (P.Estado = 2 OR P.Estado = 3);";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        //ejecutandola
        $query->execute();
        //obteniendo el resultado en un arreglo asociativo
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->conexion = null;
        return $result;
    }

    public function seleccionar_especifico(){
        //sql de la consulta, utilozo INNER JOIN porque necesito todos los datos de los postulantes, sean nulos o no
        $sql = "SELECT P.Id_Postulante, P.Nombres, P.Apellidos, DP.Id_Detalle_Postulante, DATE_FORMAT(DP.Fecha_Nacimiento, '%d/%m/%Y') AS Fecha_Nacimiento, 
        CONCAT(DP.Tel_Fijo, ', ' ,DP.Tel_Movil) AS Telefonos, DP.Tel_Fijo, DP.Tel_Movil,  DP.DUI, DP.NIT, DP.Imagen, P.Correo, 
        IP.Id_Institucion_Procedencia, IP.Institucion_Procedencia, E.Id_Especialidad, E.Especialidad, 
        DP.Anio_Inicio_B, DP.Anio_Fin_B, C.Id_Carrera, C.Carrera, C.Descripcion, P.Estado,
        (CASE 
        WHEN P.Estado = 1 THEN 'Sin iniciar'
        WHEN P.Estado = 2 THEN 'Guardada'
        WHEN P.Estado = 3 THEN 'Finalizada'
        END) AS Estado_Str
        FROM postulante P
        INNER JOIN detalle_postulante DP ON DP.Id_Postulante = P.Id_Postulante
        INNER JOIN institucion_procedencia IP ON DP.Id_Institucion_Procedencia = IP.Id_Institucion_Procedencia
        INNER JOIN especialidad E ON DP.Id_Especialidad = E.Id_Especialidad
        INNER JOIN carrera C ON DP.Id_Carrera = C.Id_Carrera
        AND P.Id_Postulante = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->id_postulante);
        //ejecutandola
        $query->execute();
        //obteniendo el resultado en un arreglo asociativo
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->conexion = null;
        return $result;
    }

    public function seleccionar_postulantes_x_carrera(){
        //sql de la consulta, utilozo INNER JOIN porque necesito todos los datos de los postulantes, sean nulos o no
        $sql = "SELECT P.Id_Postulante, P.Nombres, P.Apellidos, DP.Id_Detalle_Postulante, DATE_FORMAT(DP.Fecha_Nacimiento, '%d/%m/%Y') AS Fecha_Nacimiento, 
        CONCAT(DP.Tel_Fijo, ', ' ,DP.Tel_Movil) AS Telefonos, DP.Tel_Fijo, DP.Tel_Movil,  DP.DUI, DP.NIT, DP.Imagen, P.Correo, 
        IP.Id_Institucion_Procedencia, IP.Institucion_Procedencia, E.Id_Especialidad, E.Especialidad, 
        DP.Anio_Inicio_B, DP.Anio_Fin_B, C.Id_Carrera, C.Carrera, C.Descripcion, P.Estado
        FROM postulante P
        INNER JOIN detalle_postulante DP ON DP.Id_Postulante = P.Id_Postulante
        INNER JOIN institucion_procedencia IP ON DP.Id_Institucion_Procedencia = IP.Id_Institucion_Procedencia
        INNER JOIN especialidad E ON DP.Id_Especialidad = E.Id_Especialidad
        INNER JOIN carrera C ON DP.Id_Carrera = C.Id_Carrera
        AND (P.Estado = 2 OR P.Estado = 3)
        ORDER BY C.Id_Carrera";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->id_postulante);
        //ejecutandola
        $query->execute();
        //obteniendo el resultado en un arreglo asociativo
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->conexion = null;
        return $result;
    }

    public function seleccionar_postulantes_x_institucion(){
        //sql de la consulta, utilozo INNER JOIN porque necesito todos los datos de los postulantes, sean nulos o no
        $sql = "SELECT P.Id_Postulante, P.Nombres, P.Apellidos, DP.Id_Detalle_Postulante, DATE_FORMAT(DP.Fecha_Nacimiento, '%d/%m/%Y') AS Fecha_Nacimiento, 
        CONCAT(DP.Tel_Fijo, ', ' ,DP.Tel_Movil) AS Telefonos, DP.Tel_Fijo, DP.Tel_Movil,  DP.DUI, DP.NIT, DP.Imagen, P.Correo, 
        IP.Id_Institucion_Procedencia, IP.Institucion_Procedencia, E.Id_Especialidad, E.Especialidad, 
        DP.Anio_Inicio_B, DP.Anio_Fin_B, C.Id_Carrera, C.Carrera, C.Descripcion, P.Estado
        FROM postulante P
        INNER JOIN detalle_postulante DP ON DP.Id_Postulante = P.Id_Postulante
        INNER JOIN institucion_procedencia IP ON DP.Id_Institucion_Procedencia = IP.Id_Institucion_Procedencia
        INNER JOIN especialidad E ON DP.Id_Especialidad = E.Id_Especialidad
        INNER JOIN carrera C ON DP.Id_Carrera = C.Id_Carrera
        AND (P.Estado = 2 OR P.Estado = 3)
        ORDER BY IP.Id_Institucion_Procedencia";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->id_postulante);
        //ejecutandola
        $query->execute();
        //obteniendo el resultado en un arreglo asociativo
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->conexion = null;
        return $result;
    }

    public function contar_solicitudes_x_estado(){
        //sql de la consulta, utilozo INNER JOIN porque necesito todos los datos de los postulantes, sean nulos o no
        $sql = "SELECT COUNT(*) AS Cantidad, (
            CASE 
                WHEN P.Estado = 1 THEN 'Sin iniciar'
                WHEN P.Estado = 2 THEN 'Guardadas'
                WHEN P.Estado = 3 THEN 'Finalizadas'
                END) AS Estado
        FROM postulante P
        GROUP BY P.Estado";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //ejecutandola
        $query->execute();
        //obteniendo el resultado en un arreglo asociativo
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->conexion = null;
        return $result;
    }

    public function contar_postulantes_x_carrera(){
        //sql de la consulta, utilozo INNER JOIN porque necesito todos los datos de los postulantes, sean nulos o no
        $sql = "SELECT COUNT(*) AS Cantidad, C.Carrera
        FROM postulante P, detalle_postulante DP, carrera C
        WHERE P.Id_Postulante = DP.Id_Postulante
        AND C.Id_Carrera = DP.Id_Carrera
        AND P.Estado = 3
        GROUP BY C.Carrera";
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
        $sql = "INSERT INTO 
        detalle_postulante (
            Id_Postulante, Id_Institucion_Procedencia, Id_Especialidad, Anio_Inicio_B, Anio_Fin_B, 
            Id_Carrera, Tel_Fijo, Tel_Movil, Fecha_Nacimiento, DUI, NIT, Imagen, Estado
        ) VALUES (
            ?,?,?,?,?,?,?,?,?,?,?,?,?
        );";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->id_postulante);
        $query->bindParam(2, $this->id_institucion_procedencia);
        $query->bindParam(3, $this->id_especialidad);
        $query->bindParam(4, $this->anio_inicio_b);
        $query->bindParam(5, $this->anio_fin_b);
        $query->bindParam(6, $this->id_carrera);
        $query->bindParam(7, $this->tel_fijo);
        $query->bindParam(8, $this->tel_movil);
        $query->bindParam(9, $this->fecha_nacimiento);
        $query->bindParam(10, $this->dui);
        $query->bindParam(11, $this->nit);
        $query->bindParam(12, $this->imagen);
        $query->bindParam(13, $this->estado);
        //ejecutando
        $result = $query->execute();
        $this->id_detalle_postulante = $this->conexion->lastInsertId();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function editar(){
        //sql de la consulta
        $sql = "UPDATE detalle_postulante SET 
        Id_Postulante = ?, Id_Institucion_Procedencia = ?, Id_Especialidad = ?, Anio_Inicio_B = ?, 
        Anio_Fin_B = ?, Id_Carrera = ?, Tel_Fijo = ?, Tel_Movil = ?, Fecha_Nacimiento = ?, DUI = ?, NIT = ?, Imagen = ?
        WHERE Id_Detalle_Postulante = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->id_postulante);
        $query->bindParam(2, $this->id_institucion_procedencia);
        $query->bindParam(3, $this->id_especialidad);
        $query->bindParam(4, $this->anio_inicio_b);
        $query->bindParam(5, $this->anio_fin_b);
        $query->bindParam(6, $this->id_carrera);
        $query->bindParam(7, $this->tel_fijo);
        $query->bindParam(8, $this->tel_movil);
        $query->bindParam(9, $this->fecha_nacimiento);
        $query->bindParam(10, $this->dui);
        $query->bindParam(11, $this->nit);
        $query->bindParam(12, $this->imagen);
        $query->bindParam(13, $this->id_detalle_postulante);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }

    public function eliminar(){
        //sql de la consulta
        $sql = "UPDATE detalle_postulante SET Estado = ? WHERE Id_Detalle_Postulante = ?;";
        //preparando la consulta
        $query = $this->conexion->prepare($sql);
        //bindeando los parametros de la consulta prepar
        $query->bindParam(1, $this->estado);
        $query->bindParam(2, $this->id_detalle_postulante);
        //ejecutando
        $result = $query->execute();
        //retornando true si se ejecuto, false si no
        return $result;
    }
}

?>