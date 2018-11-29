<?php

class Flight {

    private $id;
    private $fecha_salida;
    private $fecha_llegada;
    private $capacidad;
    private $ciudad_origen;
    private $ciudad_destino;
    private $pais_origen;
    private $pais_destino;
    private $precio;
    
    public function __construct($id, $fecha_salida, $fecha_llegada, $capacidad, $ciudad_origen, $ciudad_destino, $pais_origen, $pais_destino, $precio) {

        $this->id = $id;
        $this->fecha_salida = $fecha_salida;
        $this->fecha_llegada = $fecha_llegada;
        $this->capacidad = $capacidad;
        $this->ciudad_origen = $ciudad_origen;
        $this->ciudad_destino = $ciudad_destino;
        $this->pais_origen = $pais_origen;
        $this->pais_destino = $pais_destino;
        $this->precio = $precio;
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

    public function getPaisOrigen() {
        return $this->pais_origen;
    }

    public function getPaisDestino() {
        return $this->pais_destino;
    }

    public function getPrecio() {
        return $this->precio;
    }
}

?>