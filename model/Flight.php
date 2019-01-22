<?php

class Flight {

    private $id;
    private $fecha_salida;
    private $fecha_llegada;
    private $capacidad_economica;
    private $capacidad_primera;
    private $capacidad_ejecutiva;
    private $ciudad_origen;
    private $ciudad_destino;
    private $aereolinea;
  
    private $precio;

    
    public function __construct($id, $fecha_salida, $fecha_llegada,$ciudad_origen, $ciudad_destino, $precio, $capacidad_economica,$capacidad_ejecutiva, $capacidad_primera, $aereolinea) {

        $this->id = $id;
        $this->fecha_salida = $fecha_salida;
        $this->fecha_llegada = $fecha_llegada;
        $this->capacidad_economica = $capacidad_economica;
        $this->capacidad_primera = $capacidad_primera;
        $this->capacidad_ejecutiva = $capacidad_ejecutiva;
        $this->ciudad_origen = $ciudad_origen;
        $this->ciudad_destino = $ciudad_destino;
        $this->precio = $precio;
        $this->aereolinea = $aereolinea;
    }

    public function getId() {
        return $this->id;
    }

    public function getFechaSalida() {
        return $this->fecha_salida;
    }

    public function getFechaLlegada() {
        return $this->fecha_llegada;
    }

    public function getCapacidad() {
        return $this->capacidad;
    }

    public function getCiudadOrigen() {
        return $this->ciudad_origen;
    }

    public function getCiudadDestino() {
        return $this->ciudad_destino;
    }


    public function getPrecio() {
        return $this->precio;
    }

    public function getEscala() {
        return $this->escala;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getAereolinea() {
        return $this->aereolinea;
    }
}

?>