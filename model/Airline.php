<?php

class Airline {

    private $id;
    private $nombre;
    private $reputacion_id;

    
    public function __construct($id, $nombre, $reputacion_id) {

        $this->id = $id;
        $this->nombre = $nombre;
        $this->reputacion_id= $reputacion_id;

    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getReputacion_id() {
        return $this->reputacion_id;
    }



}

?>