<?php

class ClaseRepository extends PDORepository {

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
    	$query = ClaseRepository::getInstance()->queryList("SELECT * FROM clase", array());
        
        $clases = [];
        #var_dump($query[0]);die;
        foreach ($query[0] as $row) {
            #var_dump($row['descripcion']);die;
            $clase = new Clase ( $row['id'], $row['descripcion']);
            $clases[]=$clase;
        }
        #var_dump($clases[0]);die;
        $query = null;
        return $clases;
    }

    public function getClase($idClase)
    {
        $query = FlightRepository::getInstance()->queryList("select * FROM clase where id = ?", array($idClase));

        $clases = [];
        foreach ($query[0] as $row) {
            #var_dump($row);
            $clase = new Clase($row['id'], $row['descripcion']);
            $clases[] = $clase;
        }
        $query = null;
        return $clases;
    }

}
  