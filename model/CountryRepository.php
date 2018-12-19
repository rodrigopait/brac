<?php

class CountryRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function listAll()
    {
    	$query = $this->queryList("SELECT * FROM pais ORDER BY nombre", array());
    	foreach ($query[0] as $row) {
    	    $country = new Country( $row['id'], $row['nombre']);
    	    $countries[]=$country;
    	}
    	return $countries;
    }

    //PAISES Y CIUDADES CON CONCESIONARIAS
    public function listWithConcessionaries()
    {
        $query = $this->queryList("SELECT ci.pais_id as id, p.nombre as nombre FROM ciudad ci INNER JOIN concesionaria co INNER JOIN pais p WHERE ci.id = co.ciudad_id and ci.pais_id = p.id GROUP BY ci.pais_id, p.nombre ORDER by p.nombre", array());
        $countries = array();
        foreach ($query[0] as $row) {
            $country = new Country( $row['id'], $row['nombre']);
            $countries[]=$country;
        }
        return $countries;
    }


    //PAISES Y CIUDADES CON HOTELES Y HABITACIONES
    public function listWithRoom()
    {
        $query = $this->queryList("SELECT ci.pais_id as id, p.nombre as nombre FROM ciudad ci INNER JOIN hotel h INNER JOIN pais p WHERE ci.id = h.ciudad_id and ci.pais_id = p.id GROUP BY ci.pais_id, p.nombre ORDER by p.nombre", array());
        $countries = array();
        foreach ($query[0] as $row) {
            $country = new Country( $row['id'], $row['nombre']);
            $countries[]=$country;
        }
        return $countries;
    }




    

}