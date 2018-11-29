<?php

class CarRepository extends PDORepository {

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

    public function listFromSearch($fechaDesde, $fechaHasta, $capacidad, $ciudadDestino, $paisDestino) {

        $cars = null;
        $query = RoomRepository::getInstance()->queryList("SELECT * FROM auto WHERE capacidad = ? AND ciudad = ? AND pais = ? AND id NOT IN (SELECT id_auto FROM auto_alquiler WHERE (desde BETWEEN ? AND ?) OR (hasta BETWEEN ? AND ?) OR (desde < ? AND hasta > ?))", array($capacidad, $ciudadDestino, $paisDestino, $fechaDesde, $fechaHasta, $fechaDesde, $fechaHasta, $fechaDesde, $fechaHasta));

        foreach ($query[0] as $row) {
            $car = new Car ( $row['id'], $row['precio'], $row['capacidad'], $row['modelo'], $row['ciudad'], $row['pais']);
            $cars[]=$car;
        }

        $query = null;
        return $cars;
    }
}
?>