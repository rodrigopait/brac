<?php

class RoomRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    // public function listAll() {

    //     $query = RoomRepository::getInstance()->queryList("SELECT * FROM habitacion", array());
    //     foreach ($query[0] as $row) {
    //         $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['capacidad'], $row['ciudad_origen'], $row['ciudad_destino'], $row['pais_origen'], $row['pais_destino'], $row['precio']);
    //         $flights[]=$flight;
    //     }
    //     $query = null;
    //     return $flights;
    // }

    public function listFromSearch($fechaDesde, $fechaHasta, $minimoEstrellas, $maximoEstrellas, $ciudadDestino, $paisDestino, $capacidad) {

        $rooms=null;
        $query = RoomRepository::getInstance()->queryList("SELECT * FROM habitacion WHERE (estrellas BETWEEN ? AND ?) AND ciudad = ? AND pais = ? AND capacidad = ? AND id NOT IN (SELECT id_habitacion FROM habitacion_alquiler WHERE (desde BETWEEN ? AND ?) OR (hasta BETWEEN ? AND ?) OR (desde < ? AND hasta > ?))", array($minimoEstrellas, $maximoEstrellas, $ciudadDestino, $paisDestino, $capacidad, $fechaDesde, $fechaHasta, $fechaDesde, $fechaHasta, $fechaDesde, $fechaHasta));

        foreach ($query[0] as $row) {
            $room = new Room ( $row['id'], $row['capacidad'], $row['precio'], $row['estrellas'], $row['ciudad'], $row['pais']);
            $rooms[]=$room;
        }

        $query = null;
        return $rooms;
    }
}
?>