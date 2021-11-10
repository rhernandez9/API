<?php

class DbPacientes {
 
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . './DbConnect.php';
        //Abriendo la conexion a la base de datos
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    /*seleccionarPaciente: recolecta todos los registros de la tabla pacientes*/
    public function seleccionarPaciente(){
        $sql =  "SELECT * FROM pacientes";
        $stmt=  $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /*ingresarPaciente: ingresa los datos a la tabla pacientes
        @params:
        [String] nombres: nombre del paciente que se ingresa
        [String] apellidos: apellido del paciente que se ingresa
        [String] correo: correo del paciente que se ingresa
        [String] direccion: direccion del paciente que se ingresa
        [String] telefono: telefono del paciente que se ingresa
        [String] contrasena: contaseña del paciente que se ingresa
    */
    public function ingresarPaciente($params){
        //Array que contendra los valores para el insert
        $valores = array();
        $valores['id_paciente'] = $this->idPaciente();
        $valores['nombres'] = $params['nombres'];
        $valores['apellidos'] = $params['apellidos'];
        $valores['correo'] = $params['correo'];
        $valores['direccion'] = $params['direccion'];
        $valores['telefono'] = $params['telefono'];
        $valores['contrasena'] = $params['contrasena'];

        $sql = "INSERT INTO pacientes (id_paciente,nombres,apellidos,correo,direccion,telefono,contrasena) VALUES (:id_paciente,:nombres,:apellidos,:correo,:direccion,:telefono,:contrasena)";
        $stmt=  $this->conn->prepare($sql);
        $response = $stmt->execute($valores);
        return $response;
    }
    /*eliminarPaciente: elimina los datos del paciente
        @params:
        [String] id_paciente: id del paciente que se eliminara
    */
    public function eliminarPaciente($params){
        $sql = "DELETE FROM pacientes WHERE id_paciente = :id_paciente";
        $stmt= $this->conn->prepare($sql);
        $response = $stmt->execute($params);
        return $response;
    }
    /*paciente: Selecciona el paciente especifico por su Id
        @params:
        [String] id_paciente: id del paciente que se buscara
    */
    public function paciente($params){
        $sql = "SELECT * FROM pacientes WHERE id_paciente = :id_paciente";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /*idPaciente: crea aleatoriamente un codigo para el insert de los pacientes*/
    public function idPaciente(){
        $uniqid = uniqid("pc");
        return $uniqid;
    }
}
?>