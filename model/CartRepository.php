<?php

class CartRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function listAll(){
        $flights = null;
        $cars = null;
        $rooms = null;
        foreach ($_SESSION['flights'] as $flightId) {
            $query = FlightRepository::getInstance()->queryList("SELECT * FROM vuelo WHERE id = ?", array($flightId));
            foreach ($query[0] as $row) {
                $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['capacidad'], $row['ciudad_origen'], $row['ciudad_destino'], $row['pais_origen'], $row['pais_destino'], $row['precio']);
                $flights[]=$flight;
            }
        }

        foreach ($_SESSION['rooms'] as $roomId) {
            $query = RoomRepository::getInstance()->queryList("SELECT * FROM habitacion WHERE id = ?", array($roomId));
            foreach ($query[0] as $row) {
                $key = array_search($roomId, $_SESSION['rooms']);
                $room = new Room ( $row['id'], $row['capacidad'], $row['precio'], $row['estrellas'], $row['ciudad'], $row['pais']);
                $room->setFechaDesde($_SESSION['roomsFechaDesde'][$key+1]);
                $room->setFechaHasta($_SESSION['roomsFechaHasta'][$key+1]);
                $rooms[]=$room;
            }
        }
        
        if ($_SESSION['cars'] != null){
            foreach ($_SESSION['cars'] as $carId) {
                $query = CarRepository::getInstance()->queryList("SELECT * FROM auto WHERE id = ?", array($carId));
                foreach ($query[0] as $row) {
                    $key = array_search($carId, $_SESSION['cars']);
                    $car = new Car ( $row['id'], $row['precio'], $row['capacidad'], $row['modelo'], $row['ciudad'], $row['pais']);
                    $car->setFechaDesde($_SESSION['carsFechaDesde'][$key+1]);
                    $car->setFechaHasta($_SESSION['carsFechaHasta'][$key+1]);
                    $cars[]=$car;
                }
            }
        }
        $cart = new Cart($flights, $rooms, $cars);
        return $cart;

    }

    public function addFlight($id_flight){
        if (!in_array($id_flight, $_SESSION['flights'])) {
            $_SESSION['flights'][] = $id_flight;
        }
    }

    public function addRoom($id_room, $fechaDesde, $fechaHasta){
        if (!in_array($id_room, $_SESSION['rooms'])) {
            $_SESSION['rooms'][] = $id_room;
            $_SESSION['roomsFechaDesde'][] = $fechaDesde;
            $_SESSION['roomsFechaHasta'][] = $fechaHasta;
        }
    }

    public function addCar($id_car, $fechaDesde, $fechaHasta){
        if (!in_array($id_car, $_SESSION['cars'])) {
            $_SESSION['cars'][] = $id_car;
            $_SESSION['carsFechaDesde'][] = $fechaDesde;
            $_SESSION['carsFechaHasta'][] = $fechaHasta;
        }
    }

    public function removeFlight($id_flight){
        if (($key = array_search($id_flight, $_SESSION['flights'])) !== false) {
            unset($_SESSION['flights'][$key]);
        }
    }

    public function removeRoom($id_room){
        if (($key = array_search($id_room, $_SESSION['rooms'])) !== false) {
            unset($_SESSION['rooms'][$key]);
        }
    }

    public function removeCar($id_car){
        if (($key = array_search($id_car, $_SESSION['cars'])) !== false) {
            unset($_SESSION['cars'][$key]);
            unset($_SESSION['carsFechaDesde'][$key+1]);
            unset($_SESSION['carsFechaHasta'][$key+1]);
        }
    }

}