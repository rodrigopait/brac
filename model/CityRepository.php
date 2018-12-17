<?php

class CityRepository extends PDORepository {

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
    	$query = $this->queryList("SELECT * FROM ciudad", array());
    	foreach ($query[0] as $row) {
    	    $city = new City( $row['id'], $row['nombre']);
    	    $cities[]=$city;
    	}
    	return $cities;
    }

    public function listFrom($pais_id)
    {
        $query = $this->queryList("SELECT * FROM ciudad WHERE pais_id=? ORDER BY nombre", array($pais_id));
        $cities=array();
        foreach ($query[0] as $row) {
           $city = new stdClass();
            $city->id = $row['id'];
            $city->nombre =utf8_encode($row['nombre']);
            $cities[]=$city;
        }
        return json_encode($cities);
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