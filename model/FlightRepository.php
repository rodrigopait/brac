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

    public function listFromSearch($fecha, $ciudadOrigen, $ciudadDestino, $escalas, $clase) {
        #var_dump($ciudadDestino);die;
            
        $query = FlightRepository::getInstance()->queryList("select * FROM vuelo where fecha_salida = ? AND ciudad_origen = ? AND ciudad_destino = ? AND escala = ? AND capacidad > 0 ORDER BY precio", array($fecha,$ciudadOrigen,$ciudadDestino,$escalas));
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
    public function flightAdd($data) {
        $query = $this->queryList("INSERT INTO vuelo (fecha_salida, fecha_llegada, ciudad_origen,ciudad_destino,precio,capacidad_economica,capacidad_ejecutiva,capacidad_primera,aerolinea_id) VALUES (?,?,?,?,?,?,?,?,?)",$data);
    }

    public function listFromSearchByClase1($fecha, $ciudadOrigen, $ciudadDestino, $escalas)
    {

        $query = FlightRepository::getInstance()->queryList("select * from vuelo where fecha_salida = ? AND ciudad_origen = ? AND ciudad_destino = ? AND escala >= ? AND capacidad_economica > 0 ORDER BY precio",array($fecha,$ciudadOrigen,$ciudadDestino,$escalas));

        $flights = [];

        foreach ($query[0] as $row ) {
            #var_dump($row['tipo_vuelo']);die;
            $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['capacidad_economica'], $row['capacidad_primera'], $row['capacidad_ejecutiva'], $row['ciudad_origen'], $row['ciudad_destino'], $row['precio'],$row['escala'],$row['tipo_vuelo']);
            $flights[]=$flight;
        }
        #var_dump($flights);die;
             $query = null;
        return $flights;
    }

    public function listFromSearchByClase2($fecha, $ciudadOrigen, $ciudadDestino, $escalas)
    {

        $query = FlightRepository::getInstance()->queryList("select * from vuelo where fecha_salida = ? AND ciudad_origen = ? AND ciudad_destino = ? AND escala = ? AND capacidad_primera > 0 ORDER BY precio",array($fecha,$ciudadOrigen,$ciudadDestino,$escalas));

        $flights = [];
        foreach ($query[0] as $row ) {
            #var_dump($row);die;
            $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['capacidad_economica'], $row['capacidad_primera'], $row['capacidad_ejecutiva'], $row['ciudad_origen'], $row['ciudad_destino'], $row['precio'],$row['escala'],$row['tipo_vuelo']);
            $flights[]=$flight;
        }
             $query = null;
        return $flights;
    }

    public function listFromSearchByClase3($fecha, $ciudadOrigen, $ciudadDestino, $escalas)
    {

        $query = FlightRepository::getInstance()->queryList("select * from vuelo where fecha_salida = ? AND ciudad_origen = ? AND ciudad_destino = ? AND escala = ? AND capacidad_ejecutiva > 0 ORDER BY precio",array($fecha,$ciudadOrigen,$ciudadDestino,$escalas));

        $flights = [];
        foreach ($query[0] as $row ) {
            #var_dump($row);die;
           $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['capacidad_economica'], $row['capacidad_primera'], $row['capacidad_ejecutiva'], $row['ciudad_origen'], $row['ciudad_destino'], $row['precio'],$row['escala'],$row['tipo_vuelo']);
            $flights[]=$flight;

        }
      
        $query = null;
        return $flights;
    }
}
?>