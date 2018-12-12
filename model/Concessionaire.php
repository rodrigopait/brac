<?php

class Concessionaire {

    private $id;
    private $nombre;
    private $ciudad;
    private $pais;
    private $reputacion_id;

    
    public function __construct($id, $nombre, $ciudad, $pais, $reputacion_id) {

        $this->id = $id;
        $this->nombre = $nombre;
        $this->ciudad = $ciudad;
        $this->pais=$pais;
        $this->reputacion_id= $reputacion_id;


    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getReputacion_id() {
        return $this->reputacion_id;
    }



}

?>