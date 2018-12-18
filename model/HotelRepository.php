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

    public function hotelAdd($nombre,$ciudad,$estrellas){
        $query = $this->queryList("INSERT INTO hotel (id, nombre,ciudad_id,estrellas) VALUES (?,?,?)", array($nombre,$ciudad,$estrellas));
    }

    public function listAll() {

        $query = $this->queryList("SELECT * FROM hotel ORDER BY nombre", array());
        foreach ($query[0] as $row) {
            $hotel = new Hotel( $row['id'], $row['nombre'],$row['ciudad_id'],$row['estrellas']);
            $hotels[]=$hotel;
        }
        return $hotels;
    }

        public function listFrom($idCiudad)
    {
        $query = $this->queryList("SELECT * FROM hotel WHERE ciudad_id = ? ORDER BY nombre", array($idCiudad));
        $hotels=array();
        foreach ($query[0] as $row) {
            $hotel =  new stdClass();
            $hotel->id = $row['id'];
            $hotel->nombre = utf8_encode($row['nombre']);
            $hotels[]=$hotel;
        }


        return json_encode($hotels);
    }



}