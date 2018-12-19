<?php

class Hotel {

    private $id;
    private $nombre;
    private $ciudad_id;
    private $estrellas;

    
    public function __construct($id, $nombre, $ciudad_id, $estrellas) {

        $this->id = $id;
        $this->nombre = $nombre;
        $this->ciudad_id= $ciudad_id;
        $this->estrellas= $estrellas;


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

    public function getEstrellas() {
        return $this->estrellas;
    }


}

?>