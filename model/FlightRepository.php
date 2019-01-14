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
            #var_dump($row['aerolinea_id']);die;
            $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['ciudad_origen'], $row['ciudad_destino'], $row['precio'], $row['capacidad_economica'], $row['capacidad_ejecutiva'], $row['capacidad_primera'], $row['aerolinea_id'], $row['escala'],$row['tipo_vuelo']);

            $queryOrigen = CityRepository::getInstance()->queryList("select * from ciudad where id = ?", array($flight->getCiudadOrigen()));
            $queryDestino = CityRepository::getInstance()->queryList("select * from ciudad where id = ?", array($flight->getCiudadDestino()));
            $ciudadesO = [];
            $ciudadesD = [];
            foreach ($queryOrigen[0] as $rowO) {
              $ciudadO = new City($rowO['id'],$rowO['nombre'],$rowO['pais_id']);
            }
            foreach ($queryDestino[0] as $rowD) {
              $ciudadD = new City($rowD['id'],$rowD['nombre'],$rowD['pais_id']);
            }
            #var_dump($ciudadD);die;
            $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $ciudadO->getNombre(), $ciudadD->getNombre(), $row['precio'], $row['capacidad_economica'], $row['capacidad_ejecutiva'], $row['capacidad_primera'], $row['aerolinea_id'], $row['escala'],$row['tipo_vuelo']);


            #var_dump($flights);die;
            $flights[]=$flight;
        }
           #var_dump($flights);die;
             $query = null;
        return $flights;
    }

    public function listFromSearchByClase2($fecha, $ciudadOrigen, $ciudadDestino, $escalas)
    {

        $query = FlightRepository::getInstance()->queryList("select * from vuelo where fecha_salida = ? AND ciudad_origen = ? AND ciudad_destino = ? AND escala >= ? AND capacidad_primera > 0 ORDER BY precio",array($fecha,$ciudadOrigen,$ciudadDestino,$escalas));

        $flights = [];
        foreach ($query[0] as $row ) {
            #var_dump($row);die;
            $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['ciudad_origen'], $row['ciudad_destino'], $row['precio'], $row['capacidad_economica'], $row['capacidad_ejecutiva'], $row['capacidad_primera'], $row['aerolinea_id'], $row['escala'],$row['tipo_vuelo']);
            $flights[]=$flight;
        }
             $query = null;
        return $flights;
    }

    public function listFromSearchByClase3($fecha, $ciudadOrigen, $ciudadDestino, $escalas)
    {

        $query = FlightRepository::getInstance()->queryList("select * from vuelo where fecha_salida = ? AND ciudad_origen = ? AND ciudad_destino = ? AND escala > ? AND capacidad_ejecutiva > 0 ORDER BY precio",array($fecha,$ciudadOrigen,$ciudadDestino,$escalas));

        $flights = [];
        foreach ($query[0] as $row ) {
            #var_dump($row);die;
           $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['ciudad_origen'], $row['ciudad_destino'], $row['precio'], $row['capacidad_economica'], $row['capacidad_ejecutiva'], $row['capacidad_primera'], $row['aerolinea_id'], $row['escala'],$row['tipo_vuelo']);
            $flights[]=$flight;

        }

        $query = null;
        return $flights;
    }
}

/*
vuelo directos
SELECT * FROM `vuelo` WHERE ciudad_destino = 'lisboa' AND fecha_salida BETWEEN '2018-01-10 00:00:00'  AND '2018-01-10 23:59:59' AND ciudad_origen = 'buenos aires' AND capacidad_economica >= 1
vuelos con escala
SELECT *
FROM vuelo
WHERE ciudad_origen = 'buenos aires' 
	AND fecha_salida BETWEEN '2018-01-10 00:00:00'  AND '2018-01-10 23:59:59'
    AND ciudad_destino IN (SELECT ciudad_origen 
                           FROM `vuelo` as vl 
                           WHERE ciudad_destino = 'lisboa' 
                          	 AND fecha_salida BETWEEN '2018-01-10 00:00:00'  AND '2018-01-10 23:59:59'
							AND ciudad_origen != 'buenos aires')
                            
UNION

SELECT * FROM `vuelo` as vl WHERE ciudad_destino = 'lisboa' AND fecha_salida BETWEEN '2018-01-10 00:00:00'  AND '2018-01-10 23:59:59'
AND ciudad_origen != 'buenos aires'

 */
?>
