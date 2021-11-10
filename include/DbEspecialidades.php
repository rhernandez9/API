<?php

class DbEspecialidades {
 
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . './DbConnect.php';
        //Abriendo la conexion a la base de datos
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    /*seleccionarEspecialidad: recolecta todos los registros de la tabla especialidades*/
    public function seleccionarEspecialidad(){
        $sql =  "SELECT * FROM especialidades";
        $stmt=  $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /*ingresarHorario: ingresa los datos a la tabla especialidades
        @params:
        [String] especialidad: valor de la especialidad que se ingresa
    */
    public function ingresarEspecialidad($params){
        //Array que contendra los valores para el insert
        $valores = array();
        $valores['id_especialidad'] = $this->idEspecialidad();
        $valores['especialidad'] = $params['especialidad'];

        $sql = "INSERT INTO especialidades (id_especialidad,especialidad) VALUES (:id_especialidad, :especialidad)";
        $stmt=  $this->conn->prepare($sql);
        $response = $stmt->execute($valores);
        return $response;
    }
    /*eliminarEspecialidad: elimina los datos de la especialidad
        @params:
        [String] id_especialidad: id de la especialidad que se eliminara
    */
    public function eliminarEspecialidad($params){
        $sql = "DELETE FROM especialidades WHERE id_especialidad = :id_especialidad";
        $stmt= $this->conn->prepare($sql);
        $response = $stmt->execute($params);
        return $response;
    }
    /*especialidad: Selecciona la especialidad especifica por su Id
        @params:
        [String] id_especialidad: id de la especialidad que se buscara
    */
    public function especialidad($params){
        $sql = "SELECT * FROM especialidades WHERE id_especialidad = :id_especialidad";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /*idEspecialidad: crea aleatoriamente un codigo para el insert de las especialidades */
    public function idEspecialidad(){
        $uniqid = uniqid("esp");
        return $uniqid;
    }
}
?>