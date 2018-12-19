<?php

class Concessionaire {

    private $id;
    private $nombre;
    private $ciudad_id;
    private $reputacion_id;

    
    public function __construct($id, $nombre, $ciudad_id,$reputacion_id) {

        $this->id = $id;
        $this->nombre = $nombre;
        $this->ciudad_id = $ciudad_id;
        $this->reputacion_id= $reputacion_id;


    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCiudadId() {
        return $this->ciudad_id;
    }

    public function getReputacion_id() {
        return $this->reputacion_id;
    }



}

?>