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

    public function concessionaryAdd($nombre,$ciudad,$pais,$reputacion_id){
        $query = $this->queryList("INSERT INTO concesionaria (nombre,ciudad,pais,reputacion_id) VALUES (?,?,?,?)", array($nombre,$ciudad,$pais,$reputacion_id));
    }

    public function listAll() {

        $query = $this->queryList("SELECT * FROM concesionaria", array());
        foreach ($query[0] as $row) {
            $concessionaire = new Concessionaire( $row['id'], $row['nombre'], $row['ciudad'], $row['pais'], $row['reputacion_id']);
            $concessionaires[]=$concessionaire;
        }
        return $concessionaires;
    }

}