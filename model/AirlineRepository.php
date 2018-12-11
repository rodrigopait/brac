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

    public function airline_add($nombre,$reputacion_id){
        $query = $this->queryList("INSERT INTO aerolinea (nombre, reputacion_id) VALUES (?,?)", array($nombre, $reputacion_id);
    }

}