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
        
        #var_dump($query[0]);die;
        foreach ($query[0] as $row) {
            #var_dump($row['escala']);die;
            $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['capacidad'], $row['ciudad_origen'], $row['ciudad_destino'], $row['pais_origen'], $row['pais_destino'], $row['precio'],$row['escala'],$row['tipo_vuelo']);
            $flights[]=$flight;
        }
        
        $query = null;
        return $flights;
    }

    public function listFromSearch($fecha, $ciudadOrigen, $ciudadDestino, $paisOrigen, $paisDestino, $escalas) {
        #var_dump($ciudadDestino);die;
            
        $query = FlightRepository::getInstance()->queryList("select * FROM vuelo where fecha_salida = ? AND ciudad_origen = ? AND ciudad_destino = ? AND pais_origen = ? AND pais_destino = ? AND escala = ? AND capacidad > 0 ORDER BY precio", array($fecha,$ciudadOrigen,$ciudadDestino,$paisOrigen,$paisDestino,$escalas));
        #var_dump($query);die;
        
#var_dump($query[0]);die;
        $flights = [];
        foreach ($query[0] as $row ) {
            #var_dump($row);die;
            $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['capacidad'], $row['ciudad_origen'], $row['ciudad_destino'], $row['pais_origen'], $row['pais_destino'], $row['precio'],$row['escala'],$row['tipo_vuelo']);
            $flights[]=$flight;

        }
      
        $query = null;
        return $flights;
    }

        //agrego un vuelo
    public function flight_add($fecha_salida, $fecha_llegada, $capacidad, $ciudad_origen, $ciudad_destino,$pais_origen,$pais_destino,$precio,$aerolinea_id) {
        $query = $this->queryList("INSERT INTO vuelo (fecha_salida, fecha_llegada, capacidad, ciudad_origen,ciudad_destino,pais_origen,pais_destino,precio,aerolinea_id) VALUES (?,?,?,?,?,?,?,?,?)", array($fecha_salida, $fecha_llegada, $capacidad, $ciudad_origen, $ciudad_destino,$pais_origen,$pais_destino,$precio,$aerolinea_id));
    }
}
?>