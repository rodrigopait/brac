<?php

class HotelRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function hotelAdd($nombre,$ciudad,$pais,$reputacion_id){
        $query = $this->queryList("INSERT INTO hotel (nombre,ciudad,pais,reputacion_id) VALUES (?,?,?,?)", array($nombre,$ciudad,$pais,$reputacion_id));
    }

    public function listAll() {

        $query = $this->queryList("SELECT * FROM hotel", array());
        foreach ($query[0] as $row) {
            $hotel = new Hotel( $row['id'], $row['nombre'],$row['ciudad'],$row['pais'],$row['reputacion_id']);
            $hotels[]=$hotel;
        }
        return $hotels;
    }

}