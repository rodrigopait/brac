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

    public function citiesWithConcessionaire($idPais)
    {
        $query = $this->queryList("SELECT ci.id as id, ci.nombre as nombre  FROM ciudad ci INNER JOIN concesionaria co WHERE ci.id = co.ciudad_id and ci.pais_id = ? GROUP BY ci.id, ci.nombre ORDER by ci.nombre", array($idPais));
        $cities=array();
        foreach ($query[0] as $row) {
            $city =  new stdClass();
            $city->id = $row['id'];
            $city->nombre = utf8_encode($row['nombre']);
            $cities[]=$city;
        }


        return json_encode($cities);
    }

    

}