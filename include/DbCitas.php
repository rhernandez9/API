<?php

class DbCitas {
 
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . './DbConnect.php';
        //Abriendo la conexion a la base de datos
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    /*seleccionarCita: recolecta todos los registros de la tabla citas*/
    public function seleccionarCita(){
        $sql =  "SELECT ct.id_cita, ct.fecha,hr.horario,CONCAT(pc.nombres,' ',pc.apellidos) as paciente,CONCAT(dr.nombres,' ',dr.apellidos) as doctor
        FROM
         citas as ct INNER JOIN horarios as hr ON hr.id_horario = ct.horario 
         INNER JOIN pacientes as pc ON pc.id_paciente = ct.paciente 
         INNER JOIN doctores as dr on dr.id_doctor = ct.doctor";
        $stmt=  $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /*ingresarHorario: ingresa los datos a la tabla citas
        @params:
        [Date] fecha: fecha programada para la cita
        [String] horario: id del horario para la cita
        [String] paciente: id del paciente que reservo la cita
        [String] doctor: id del doctor seleccionado para la cita 
    */
    public function ingresarCita($params){
        //Array que contendra los valores para el insert
        $valores = array();
        $valores['id_cita'] = $this->idCita();
        $valores['fecha'] = $params['fecha'];
        $valores['horario'] = $params['horario'];
        $valores['paciente'] = $params['paciente'];
        $valores['doctor'] = $params['doctor'];

        $sql = "INSERT INTO citas (id_cita,fecha,horario,paciente,doctor) VALUES (:id_cita,:fecha,:horario,:paciente,:doctor)";
        $stmt=  $this->conn->prepare($sql);
        $response = $stmt->execute($valores);
        return $response;
    }
    /*eliminarEspecialidad: elimina los datos de la especialidad
        @params:
        [String] id_cita: id de la especialidad que se eliminara
    */
    public function eliminarEspecialidad($params){
        $sql = "DELETE FROM citas WHERE id_cita = :id_cita";
        $stmt= $this->conn->prepare($sql);
        $response = $stmt->execute($params);
        return $response;
    }
    /*especialidad: Selecciona la especialidad especifica por su Id
        @params:
        [String] id_especialidad: id de la especialidad que se buscara
    */
    public function cita($params){
        $sql = "SELECT ct.id_cita, ct.fecha,hr.horario,CONCAT(pc.nombres,' ',pc.apellidos) as paciente,CONCAT(dr.nombres,' ',dr.apellidos) as doctor FROM
        citas as ct INNER JOIN horarios as hr ON hr.id_horario = ct.horario 
        INNER JOIN pacientes as pc ON pc.id_paciente = ct.paciente 
        INNER JOIN doctores as dr on dr.id_doctor = ct.doctor WHERE ct.id_cita = :id_cita";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /*idCita: crea aleatoriamente un codigo para el insert de las citas */
    public function idCita(){
        $uniqid = uniqid("ct");
        return $uniqid;
    }
}
?>