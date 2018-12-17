<?php

class ConcessionaireRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function concessionaireAdd($nombre,$ciudad){
        $query = $this->queryList("INSERT INTO concesionaria (nombre,ciudad_id,reputacion_id) VALUES (?,?,?)", array($nombre,$ciudad,0));
    }

    public function listAll() {

        $query = $this->queryList("SELECT * FROM concesionaria", array());
        foreach ($query[0] as $row) {
            $concessionaire = new Concessionaire( $row['id'], $row['nombre'], $row['ciudad_id'],$row['reputacion_id']);
            $concessionaires[]=$concessionaire;
        }
        return $concessionaires;
    }

    public function listFrom($idCiudad)
    {
        $query = $this->queryList("SELECT * FROM concesionaria WHERE ciudad_id = ? ORDER BY nombre", array($idCiudad));
        $concessionaires=array();
        foreach ($query[0] as $row) {
            $concessionaire =  new stdClass();
            $concessionaire->id = $row['id'];
            $concessionaire->nombre = utf8_encode($row['nombre']);
            $concessionaires[]=$concessionaire;
        }


        return json_encode($concessionaires);
    }

}