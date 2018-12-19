<?php

class Room {

    private $id;
    private $capacidad;
    private $precio;
    private $hotel;
    private $ciudadDestino;
    private $paisDestino;
    private $fechaDesde;
    private $fechaHasta;
    
    public function __construct($id, $capacidad, $precio, $hotel, $ciudadDestino, $paisDestino) {

        $this->id = $id;
        $this->capacidad = $capacidad;
        $this->precio = $precio;
        $this->hotel = $hotel;
        $this->ciudadDestino = $ciudadDestino;
        $this->paisDestino = $paisDestino;
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
    
    public function getPrecio() {
        return $this->precio;
    }

    public function getHotel() {
        return $this->hotel;
    }

    public function getCiudadDestino() {
        return $this->ciudadDestino;
    }

    public function getPaisDestino() {
        return $this->paisDestino;
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