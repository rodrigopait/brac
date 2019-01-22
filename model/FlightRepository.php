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

    public function flightSearchById($id)
    {
      $query = $this->queryList("SELECT * FROM vuelo inner join aerolinea on(vuelo.aerolinea_id = aereolinea.id)WHERE id=?", array($id));

      foreach ($query[0] as $row) {
          $flight = new Flight( $row['id'], $row['fecha_salida'],$row['fecha_llegada'],$row['ciudad_origen'],$row['ciudad_destino'],$row['precio'],$row['capacidad_economica'],$row['capacidad_ejecutiva'],$row['capacidad_primera'],$row['nombre']);
      }
      return $flight;
    }

    //agrego un vuelo
    public function flightAdd($data) {
        $query = $this->queryList("INSERT INTO vuelo (fecha_salida, fecha_llegada, ciudad_origen,ciudad_destino,precio,capacidad_economica,capacidad_ejecutiva,capacidad_primera,aerolinea_id) VALUES (?,?,?,?,?,?,?,?,?)",$data);
    }

    //Busqueda de vuelos directos y con escalas
    public function flightSearch($destino,$fecha_desde,$fecha_hasta,$origen,$pasajeros,$clase)
    {   

        $data=array($destino,$fecha_desde,$fecha_hasta,$origen,$pasajeros);
        //Busqueda de vuelos directos

        if ($clase == 'economica') {
            $clase = 'capacidad_economica';
        }
        elseif ($clase == 'ejecutiva') {
            $clase = 'capacidad_ejecutiva';
        }
        else{
            $clase = 'capacidad_primera';
        }
        $sqlDirectos="SELECT vuelo.id,
                             vuelo.fecha_salida,
                             vuelo.fecha_llegada,
                             vuelo.ciudad_origen,
                             vuelo.ciudad_destino,
                             vuelo.precio,
                             aerolinea.nombre as aerolinea

                      FROM  vuelo inner join aerolinea on(vuelo.aerolinea_id = aerolinea.id)
                      WHERE
                            
                            ciudad_destino = ? 
                            AND fecha_salida BETWEEN ?  AND ? 
                            AND ciudad_origen = ? 
                            AND ".$clase." >= ?";

                  
        $query=$this->queryList($sqlDirectos,$data);

        $directos= array();
        foreach ($query[0] as $row) {
            $flight =  new stdClass();
            $flight->id = $row['id'];
            $flight->fechaSalida  = $row['fecha_salida'];
            $flight->fechaLlegada = $row['fecha_llegada'];
            $flight->ciudadOrigen = $row['ciudad_origen'];
            $flight->ciudadDestino= $row['ciudad_destino'];
            $flight->precio  = $row['precio'];
            $flight->aerolinea=$row['aerolinea'];
            $directos[]=$flight;
        }
        $vuelos=array();
        $vuelos['directos']=$directos;

        //Busqueda de vuelos con escalas

        $sqlEscalas="
        SELECT vuelo.id,
               vuelo.fecha_salida,
               vuelo.fecha_llegada,
               vuelo.ciudad_origen,
               vuelo.ciudad_destino,
               vuelo.precio,
               aerolinea.nombre as aerolinea
        FROM vuelo inner join aerolinea on(vuelo.aerolinea_id = aerolinea.id)
        WHERE ciudad_origen = ? 
            AND fecha_salida BETWEEN ? AND ?
            AND ciudad_destino IN (SELECT ciudad_origen 
                                   FROM vuelo as vl 
                                   WHERE ciudad_destino = ?
                                     AND fecha_salida BETWEEN ?  AND ?
                                    AND ciudad_origen != ?
                                    AND ".$clase." >= ?)

                                    
        UNION

        SELECT vuelo.id,
               vuelo.fecha_salida,
               vuelo.fecha_llegada,
               vuelo.ciudad_origen,
               vuelo.ciudad_destino,
               vuelo.precio,
               aerolinea.nombre as aerolinea
        FROM vuelo inner join aerolinea on(vuelo.aerolinea_id = aerolinea.id)
        WHERE 
            ciudad_destino = ? 
            AND fecha_salida BETWEEN ?  AND ?
            AND ciudad_origen != ?
            AND ".$clase." >= ?";

        $data1=array($origen,$fecha_desde,$fecha_hasta,$destino,$fecha_desde,$fecha_hasta,$origen,$pasajeros,$destino,$fecha_desde,$fecha_hasta,$origen,$pasajeros);

        
        
        $queryEscala=$this->queryList($sqlEscalas,$data1);
        $aux=array();
        $vuelosEscala=array();
        foreach ($queryEscala[0] as $row) {

            $flight =  new stdClass();
            $flight->id = $row['id'];
            $flight->fechaSalida  = $row['fecha_salida'];
            $flight->fechaLlegada = $row['fecha_llegada'];
            $flight->ciudadOrigen = $row['ciudad_origen'];
            $flight->ciudadDestino= $row['ciudad_destino'];
            $flight->precio  = $row['precio'];
            $flight->aerolinea=$row['aerolinea'];
            if (!empty($aux)) {
                foreach ($aux as $vuelo) {
                    $escala=array();
                    if ($vuelo->ciudadDestino == $flight->ciudadOrigen && $vuelo->aerolinea == $flight->aerolinea) {
                        $escala['vuelos'][]=$vuelo;
                        $escala['vuelos'][]=$flight;
                        $escala['precio']=$vuelo->precio+$flight->precio;
                        $vuelosEscala[]=$escala;
                    }
                }
            }
            $aux[]=$flight;
        }
        $vuelos['escalas']=$vuelosEscala;
        return json_encode($vuelos);
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
