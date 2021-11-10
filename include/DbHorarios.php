<?php

class DbHorarios {
 
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . './DbConnect.php';
        //Abriendo la conexion a la base de datos
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    /*seleccionarHorario: recolecta todos los registros de la tabla horarios*/
    public function seleccionarHorario(){
        $sql =  "SELECT * FROM horarios";
        $stmt=  $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /*ingresarHorario: ingresa los datos a la tabla horarios
        @params:
        [String] horario: valor del horario que se ingresa
    */
    public function ingresarHorario($params){
        //Array que contendra los valores para el insert
        $valores = array();
        $response = array();
        $valores['id_horario'] = $this->idHorario();
        $valores['horario'] = $params['horario'];

        $sql = "INSERT INTO horarios (id_horario,horario) VALUES (:id_horario, :horario)";
        $stmt=  $this->conn->prepare($sql);
        $response['operacion'] = $stmt->execute($valores);
        $response['id_horario'] = $valores['id_horario'];
        return $response;
    }
    /*actualizarHorario: Actualiza los datos de la tabla horario
        @params:
        [String] id_horario: id del horario que se actualizara
        [String] horario: valor del horario que se actualizara
    */
    public function actualizarHorario($params){
        //Array que contendra los valores para el insert
        $valores = array();
        $valores['horario'] = $params['horario'];
        $valores['id_horario'] = $params['id_horario'];

        $sql = "UPDATE horarios SET horario = :horario WHERE id_horario = :id_horario";
        $stmt=  $this->conn->prepare($sql);
        $response = $stmt->execute($valores);
        return $response;
    }
    /*eliminarHorario: elimina los datos del horario
        @params:
        [String] id_horario: id del horario que se eliminara
    */
    public function eliminarHorario($params){
        $sql = "DELETE FROM horarios WHERE id_horario = :id_horario";
        $stmt= $this->conn->prepare($sql);
        $response = $stmt->execute($params);
        return $response;
    }
    /*horario: Selecciona el horario especifico por su Id
        @params:
        [String] id_horario: id del horario que se buscara
    */
    public function horario($params){
        $sql = "SELECT * FROM horarios WHERE id_horario = :id_horario";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /*idHorario: crea aleatoriamente un codigo para el insert de los horarios */
    public function idHorario(){
        $uniqid = uniqid("hr");
        return $uniqid;
    }
}
?>