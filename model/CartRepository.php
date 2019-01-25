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
        $flightsDirectos=array();
        $flightsEscalas=array();
        $rooms=array();
        if (!empty($_SESSION['carrito']['vuelos']['directos'])) {
            foreach ($_SESSION['carrito']['vuelos']['directos'] as $flightId) {
                $query = $this->queryList("SELECT v.id,
                                                  v.fecha_salida,
                                                  v.fecha_llegada,
                                                  v.ciudad_origen,
                                                  v.ciudad_destino,
                                                  v.precio,
                                                  v.capacidad_economica,
                                                  v.capacidad_ejecutiva,
                                                  v.capacidad_primera,
                                                  a.nombre
                                           FROM vuelo as v inner join aerolinea as a on(v.aerolinea_id = a.id)
                                           WHERE v.id=?", array($flightId));
                foreach ($query[0] as $row) {
                    $flight = new Flight( $row['id'], $row['fecha_salida'],$row['fecha_llegada'],$row['ciudad_origen'],$row['ciudad_destino'],$row['precio'],$row['capacidad_economica'],$row['capacidad_ejecutiva'],$row['capacidad_primera'],$row['nombre']);
                }
                $flightsDirectos[]=$flight;
            }
        }
        if (!empty($_SESSION['carrito']['vuelos']['escalas'])) {
            foreach ($_SESSION['carrito']['vuelos']['escalas']['id'] as $flightId) {
                $idEscala=explode('v',$flightId);
                $escala=array();
                $escala['precio']=0;
                $escala['id']=$flightId;
                for ($i=0; $i < count($idEscala); $i++) { 
                    $query = $this->queryList("SELECT * FROM vuelo inner join aerolinea on(vuelo.aerolinea_id = aerolinea.id)WHERE vuelo.id=?", array($idEscala[$i]));
                    foreach ($query[0] as $row) {
                        $flightEscala = new Flight( $row['id'], $row['fecha_salida'],$row['fecha_llegada'],$row['ciudad_origen'],$row['ciudad_destino'],$row['precio'],$row['capacidad_economica'],$row['capacidad_ejecutiva'],$row['capacidad_primera'],$row['nombre']);
                    }
                    $escala['vuelos'][]=$flightEscala;
                    $escala['precio']+=$flightEscala->getPrecio();
                    $escala['origen']=reset($escala['vuelos'])->getCiudadOrigen();
                    $escala['destino']=end($escala['vuelos'])->getCiudadDestino();
                }

                $flightsEscalas[]=$escala;
            }
        }
        /* $id;
    private $capacidad;
    private $precio;
    private $hotel;
    private $ciudadDestino;
    private $paisDestino;
    private $fechaDesde;
    private $fechaHasta;*/
        if (!empty($_SESSION['carrito']['rooms'])) {
            foreach ($_SESSION['carrito']['rooms'] as $room_id) {
                $query = $this->queryList("SELECT habitacion.id as id,habitacion.precio as precio, habitacion.capacidad as capacidad, ciudad.nombre as ciudad ,hotel.nombre as hotel, hotel.estrellas as estrellas, pais.nombre as pais FROM habitacion inner join hotel on(hotel.id = habitacion.hotel_id) inner join ciudad on(hotel.ciudad_id = ciudad.id) inner join pais on(ciudad.pais_id= pais.id) WHERE habitacion.id=?", array($room_id));
                foreach ($query[0] as $row) {
                    $key = array_search($room_id, $_SESSION['carrito']['rooms']) ;
                    $f_desde = $_SESSION['carrito']['roomsFechaDesde'][$key];
                    $f_hasta = $_SESSION['carrito']['roomsFechaHasta'][$key];
                    $room = new Room($row['id'],$row['capacidad'], $row['precio'],$row['hotel'],$row['ciudad'],$row['pais']);
                    $room->setFechaDesde($f_desde);
                    $room->setFechaHasta($f_hasta);

                }
                $rooms[]=$room;
            }
        }

/*        foreach ($_SESSION['rooms'] as $roomId) {

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
        }*/
        $vuelos['directos']=$flightsDirectos;
        $vuelos['escalas']=$flightsEscalas;
        $carrito['vuelos']=$vuelos;
        $carrito['rooms']=$rooms;
        return $carrito;
    }

    public function addFlight($flight){
            $escalas=strpos($flight,'v');
            if($escalas === false){
                $_SESSION['carrito']['vuelos']['directos'][]= $flight;
                $_SESSION['carrito']['directos']['datos'][]= $_SESSION['vuelos']['datos'];
            }
            else{
                $_SESSION['carrito']['vuelos']['escalas'][]= $flight;
                $_SESSION['carrito']['escalas']['datos'][]= $_SESSION['vuelos']['datos'];
            }


    }

    public function addRoom($id_room, $fechaDesde, $fechaHasta){
        if (!in_array($id_room, $_SESSION['carrito']['rooms'])) {
            $_SESSION['carrito']['rooms'][] = $id_room;
            $_SESSION['carrito']['roomsFechaDesde'][] = $fechaDesde;
            $_SESSION['carrito']['roomsFechaHasta'][] = $fechaHasta;
        }
    }

    public function addCar($id_car, $fechaDesde, $fechaHasta){
        if (!in_array($id_car, $_SESSION['cars'])) {
            $_SESSION['cars'][] = $id_car;
            $_SESSION['carsFechaDesde'][] = $fechaDesde;
            $_SESSION['carsFechaHasta'][] = $fechaHasta;
        }
    }

    public function removeFlight($flight){
        $escalas=strpos($flight,'v');
        if ($escalas === false) {
            if (($key = array_search($flight, $_SESSION['carrito']['vuelos']['directos'])) !== false) {
                unset($_SESSION['carrito']['vuelos']['directos'][$key]);
                unset($_SESSION['carrito']['directos']['datos'][$key]);

            }
        }
        else{
            if (($key = array_search($flight, $_SESSION['carrito']['vuelos']['escalas'])) !== false) {
                unset($_SESSION['carrito']['vuelos']['escalas'][$key]);
                unset($_SESSION['carrito']['escalas']['datos'][$key]);
            }
        }

    }

    public function removeRoom($id_room){
        if (($key = array_search($id_room, $_SESSION['carrito']['rooms'])) !== false) {
            unset($_SESSION['carrito']['rooms'][$key]);
            unset($_SESSION['carrito']['roomsFechaDesde'][$key]);
            unset($_SESSION['carrito']['roomsFechaHasta'][$key]);
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