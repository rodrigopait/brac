<?php

class Car {

    private $id;
    private $precio;
    private $capacidad;
    private $modelo;
    private $ciudadDestino;
    private $paisDestino;
    private $fechaDesde;
    private $fechaHasta;
    
    public function __construct($id, $precio, $capacidad, $modelo, $paisDestino, $ciudadDestino) {

        $this->id = $id;
        $this->precio = $precio;
        $this->capacidad = $capacidad;
        $this->modelo = $modelo;
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

    public function getPrecio() {
        return $this->precio;
    }

    public function getCapacidad() {
        return $this->capacidad;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getCiudadDestino() {
        return $this->ciudadDestino;
    }

    public function getPaisDestino() {
        return $this->paisDestino;
    }

    public function getFechaDesde() {
        return $this->fechaDesde;
    }

    public function getFechaHasta() {
        return $this->fechaHasta;
    }


}

?>