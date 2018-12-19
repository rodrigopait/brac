<?php

class City {

    private $id;
    private $nombre;
    private $pais_id;
    
    public function __construct($id, $nombre, $pais_id) {

        $this->id = $id;
        $this->nombre = utf8_encode($nombre);
        $this->pais_id = $pais_id;

    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPaisId() {
        return $this->pais_id;
    }
}
