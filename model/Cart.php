<?php

class Cart {
    
    private $id;
    private $vuelos;
    private $habitaciones;
    private $autos;
    
    public function __construct($vuelos, $habitaciones, $autos) {
        $this->vuelos = $vuelos;
        $this->habitaciones = $habitaciones;
        $this->autos = $autos;
    }

    public function add_flight($vuelo) {

        $this->vuelos[] = $vuelo;

    }

    public function add_car($auto) {
        
        $this->autos[] = $auto;

    }

    public function add_room($habitacion) {
        
        $this->habitaciones[] = $habitacion;

    }

    public function getId() {
        return $this->id;
    }

    public function getVuelos() {
        return $this->vuelos;
    }

    public function getHabitaciones() {
        return $this->habitaciones;
    }

    public function getAutos() {
        return $this->autos;
    }

    public function getPrice () {
        $total = 0;
        if ($this->vuelos != null) {
            foreach ($this->vuelos as $vuelo) {
                $total = $total + $vuelo->getPrecio();
            }
        }
        if ($this->autos != null) {
            foreach ($this->autos as $auto) {
                $total = $total + $auto->getPrecio();
            }
        }
        if ($this->habitaciones != null) {
            foreach ($this->habitaciones as $habitacion) {
                $total = $total + $habitacion->getPrecio();
            }
        }
        return $total;
    }

    public function getFlightsPrice () {
        $total = 0;
        if ($this->vuelos != null) {
            foreach ($this->vuelos as $vuelo) {
                $total = $total + $vuelo->getPrecio();
            }
        }
        return $total;
    }

    public function getRoomsPrice () {
        $total = 0;
        if ($this->habitaciones != null) {
            foreach ($this->habitaciones as $habitacion) {
                $total = $total + $habitacion->getPrecio();
            }
        }
        return $total;
    }

    public function getCarsPrice () {
        $total = 0;
        if ($this->autos != null) {
            foreach ($this->autos as $auto) {
                $total = $total + $auto->getPrecio();
            }
        }
        return $total;
    }
}

?>