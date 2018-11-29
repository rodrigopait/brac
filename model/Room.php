<?php

class Room {

    private $id;
    private $capacidad;
    private $precio;
    private $estrellas;
    private $ciudadDestino;
    private $paisDestino;
    private $fechaDesde;
    private $fechaHasta;
    
    public function __construct($id, $capacidad, $precio, $estrellas, $paisDestino, $ciudadDestino) {

        $this->id = $id;
        $this->capacidad = $capacidad;
        $this->ciudadDestino = $ciudadDestino;
        $this->paisDestino = $paisDestino;
        $this->precio = $precio;
        $this->estrellas = $estrellas;
    }

    public function setFechaDesde($fechaDesde) {
        return $this->fechaDesde = $fechaDesde;
    }

    public function setFechaHasta($fechaHasta) {
        return $this->fechaHasta = $fechaHasta;
    }

    public function getId() {
        return $this->id;
    }

    public function getCapacidad() {
        return $this->capacidad;
    }

    public function getCiudadDestino() {
        return $this->ciudadDestino;
    }

    public function getPaisDestino() {
        return $this->paisDestino;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getEstrellas() {
        return $this->estrellas;
    }

    public function getFechaDesde() {
        return $this->fechaDesde;
    }

    public function getFechaHasta() {
        return $this->fechaHasta;
    }
}

?>