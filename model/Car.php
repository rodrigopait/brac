<?php

class Car {

    private $id;
    private $ciudadDestino;
    private $precio;
    private $gama;
    private $modelo;
    private $marca;
    private $capacidad;
    private $patente;
    private $autonomia;
    private $paisDestino;
    private $fechaDesde;
    private $fechaHasta;
    
    public function __construct($id, $ciudadDestino, $precio, $gama, $modelo, $marca, $capacidad, $patente, $autonomia, $paisDestino) {

        $this->id = $id;
        $this->ciudadDestino = $ciudadDestino;
        $this->precio = $precio;
        $this->gama = $gama;
        $this->modelo = $modelo;
        $this->marca = $marca;
        $this->capacidad = $capacidad;
        $this->patente = $patente;
        $this->autonomia = $autonomia;
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
    
    public function getCiudadDestino() {
        return $this->ciudadDestino;
    }

    public function getPrecio() {
        return $this->precio;
    }
    
    public function getGama() {
        return $this->gama;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function getCapacidad() {
        return $this->capacidad;
    }

    public function getPatente() {
        return $this->patente;
    }

    public function getAutonomia() {
        return $this->autonomia;
    }

    public function getpaisDestino() {
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