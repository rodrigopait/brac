<?php

class FlightRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function listAll() {

        $query = FlightRepository::getInstance()->queryList("SELECT * FROM vuelo", array());
        foreach ($query[0] as $row) {
            $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['capacidad'], $row['ciudad_origen'], $row['ciudad_destino'], $row['pais_origen'], $row['pais_destino'], $row['precio']);
            $flights[]=$flight;
        }
        $query = null;
        return $flights;
    }

    public function listFromSearch($fecha, $ciudadOrigen, $ciudadDestino, $paisOrigen, $paisDestino) {

        $query = FlightRepository::getInstance()->queryList("SELECT * FROM vuelo WHERE fecha_salida = ? AND capacidad > 0 AND ciudad_origen = ? AND ciudad_destino = ? AND pais_origen = ? AND pais_destino = ? ", array($fecha, $ciudadOrigen, $ciudadDestino, $paisOrigen, $paisDestino));
        $flights = [];
        foreach ($query[0] as $row) {
            $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['capacidad'], $row['ciudad_origen'], $row['ciudad_destino'], $row['pais_origen'], $row['pais_destino'], $row['precio']);
            $flights[]=$flight;
        }
        $query = null;
        return $flights;
    }
}
?>