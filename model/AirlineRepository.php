<?php

class AirlineRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function airlinAdd($nombre,$reputacion_id){
        $query = $this->queryList("INSERT INTO aerolinea (nombre, reputacion_id) VALUES (?,?)", array($nombre, $reputacion_id));
    }

    public function listAll() {

        $query = $this->queryList("SELECT * FROM aerolinea", array());
        foreach ($query[0] as $row) {
            $airline = new Airline( $row['id'], $row['nombre'], $row['reputacion_id']);
            $airlines[]=$airline;
        }
        return $airlines;
    }
}