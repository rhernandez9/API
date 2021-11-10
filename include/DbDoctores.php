<?php

class DbDoctores {
 
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . './DbConnect.php';
        //Abriendo la conexion a la base de datos
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    /*seleccionarDoctor: recolecta todos los registros de la tabla doctores*/
    public function seleccionarDoctor(){
        $sql =  "SELECT dc.id_doctor, dc.nombres, dc.apellidos, dc.telefono,dc.licencia,dc.correo,dc.contrasena, esp.especialidad FROM 
        doctores as dc INNER JOIN especialidades as esp ON esp.id_especialidad = dc.especialidad";
        $stmt=  $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /*ingresarDoctor: ingresa los datos a la tabla doctores
        @params:
        [String] nombres: nombre del doctor que se ingresa
        [String] apellidos: apellido del doctor que se ingresa
        [String] telefono: telefono del doctor que se ingresa
        [String] licencia: licencia del doctor que se ingresa
        [String] especialidad: id de la especialidad
        [String] correo: correo del doctor que se ingresa
        [String] contrasena: contaseña del doctor que se ingresa
    */
    public function ingresarDoctor($params){
        //Array que contendra los valores para el insert
        $valores = array();
        $valores['id_doctor'] = $this->idDoctor();
        $valores['nombres'] = $params['nombres'];
        $valores['apellidos'] = $params['apellidos'];
        $valores['telefono'] = $params['telefono'];
        $valores['licencia'] = $params['licencia'];
        $valores['especialidad'] = $params['especialidad'];
        $valores['correo'] = $params['correo'];
        $valores['contrasena'] = $params['contrasena'];

        $sql = "INSERT INTO doctores (id_doctor,nombres,apellidos,telefono,licencia,especialidad,correo,contrasena) VALUES (:id_doctor,:nombres,:apellidos,:telefono,:licencia,:especialidad,:correo,:contrasena)";
        $stmt=  $this->conn->prepare($sql);
        $response = $stmt->execute($valores);
        return $response;
    }
    /*eliminarDoctor: elimina los datos del doctor
        @params:
        [String] id_doctor: id del doctor que se eliminara
    */
    public function eliminarDoctor($params){
        $sql = "DELETE FROM doctores WHERE id_doctor = :id_doctor";
        $stmt= $this->conn->prepare($sql);
        $response = $stmt->execute($params);
        return $response;
    }
    /*especialidad: Selecciona el doctor especifico por su Id
        @params:
        [String] id_doctor: id del doctor que se buscara
    */
    public function doctor($params){
        $sql = "SELECT dc.id_doctor, dc.nombres, dc.apellidos, dc.telefono,dc.licencia,dc.correo,dc.contrasena, esp.especialidad FROM 
        doctores as dc INNER JOIN especialidades as esp ON esp.id_especialidad = dc.especialidad WHERE dc.id_doctor = :id_doctor";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /*idDoctor: crea aleatoriamente un codigo para el insert de los doctores */
    public function idDoctor(){
        $uniqid = uniqid("dr");
        return $uniqid;
    }
}
?>