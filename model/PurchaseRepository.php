<?php

class PurchaseRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function purchaseAdd($usuarioId) {

        $total = 0;
        if (!empty($_SESSION['carrito']['vuelos']['directos'])) {
            foreach ($_SESSION['carrito']['vuelos']['directos'] as $flightId) {
                $precioVuelo = $this->queryList("SELECT precio FROM vuelo WHERE id = ?", array($flightId));
                foreach ($precioVuelo[0] as $row) {
                    $total += $row['precio'];
                }
                
            }
        }

        if (!empty($_SESSION['carrito']['vuelos']['escalas'])) {
            foreach ($_SESSION['carrito']['vuelos']['escalas'] as $flightId) {
                $precioVueloEscala = FlightRepository::getInstance()->queryList("SELECT precio FROM vuelo WHERE id = ?", array($flightId));
                foreach ($precioVueloEscala[0] as $row) {
                    $total += $row['precio'];
                }
            }
        }

/*        foreach ($_SESSION['rooms'] as $roomId) {
            $precioHabitacion = RoomRepository::getInstance()->queryList("SELECT precio FROM habitacion WHERE id = ?", array($roomId));
            foreach ($precioHabitacion[0] as $row) {
                $total += $row['precio'];
            }
        }

        foreach ($_SESSION['cars'] as $carId) {
            $precioAuto = CarRepository::getInstance()->queryList("SELECT precio FROM auto WHERE id = ?", array($carId));
            foreach ($precioAuto[0] as $row) {
                $total += $row['precio'];
            }
        }
*/
        //REGISTRO LA COMPRA
        $fecha_actual=date('Y-m-d H:i:s');
        $query = $this->queryList("INSERT INTO compra (fecha, total, usuario_id) VALUES (?,?,?)", array($fecha_actual, $total, $usuarioId));
        $compra_id = $query[1];


        //REGISTRO LOS VUELOS DIRECTOS DE LA COMPRA 
        if (!empty($_SESSION['carrito']['vuelos']['directos'])) {
            foreach ($_SESSION['carrito']['vuelos']['directos'] as $flightId) {
                $key = array_search($flightId, $_SESSION['carrito']['vuelos']['directos']);
                $clase=$_SESSION['carrito']['directos']['datos'][$key]['tipo'];
                $pasajeros=$_SESSION['carrito']['directos']['datos'][$key]['pasajeros'];
                $this->queryList("INSERT INTO vuelo_compra (vuelo, compra_id) VALUES (?,?)", array($flightId, $compra_id));
                $this->queryList("UPDATE vuelo SET $clase = $clase - ? WHERE id = ?", array($pasajeros, $flightId));
            }
        }

        //REGISTRO LOS VUELOS ESCALAS DE LA COMPRA 
        if (!empty($_SESSION['carrito']['vuelos']['escalas'])) {

            foreach ($_SESSION['carrito']['vuelos']['escalas'] as $flightId) {
                $key = array_search($flightId, $_SESSION['carrito']['vuelos']['escalas']);
                $clase=$_SESSION['carrito']['escalas']['datos'][$key]['tipo'];
                $pasajeros=$_SESSION['carrito']['escalas']['datos'][$key]['pasajeros'];
                $this->queryList("INSERT INTO vuelo_compra (vuelo, compra_id) VALUES (?,?)", array($flightId, $compra_id));
                $this->queryList("UPDATE vuelo SET $clase = $clase - ? WHERE id = ?", array($pasajeros, $flightId));
            }
        }


        //REGISTRO LAS HABITACIONES
        if (!empty($_SESSION['rooms'])) {
            foreach ($_SESSION['rooms'] as $index => $value) {
                $this->queryList("INSERT INTO habitacion_alquiler (desde, hasta, id_habitacion, compra_id) VALUES (?,?,?,?)", array($_SESSION['roomsFechaDesde'][$index+1], $_SESSION['roomsFechaHasta'][$index+1], $_SESSION['rooms'][$index], $compra_id));
            }
        }

        //REGISTRO LOS AUTOS
        if (!empty($_SESSION['cars'])) {
            foreach ($_SESSION['cars'] as $index => $value) {
                $this->queryList("INSERT INTO auto_alquiler (desde, hasta, id_auto, compra_id) VALUES (?,?,?,?)", array($_SESSION['carsFechaDesde'][$index+1], $_SESSION['carsFechaHasta'][$index+1], $_SESSION['cars'][$index], $compra_id));
            }
        }


    }

    public function user_purchases($usuarioId) {
        $compras=null;
        $query = $this->queryList("SELECT * FROM compra WHERE usuario_id = ?", array($usuarioId));
        foreach ($query[0] as $row) {
            $compra = new Purchase($row['id'], $row['fecha'], $row['total'], $row['usuario_id']);
            $compras[] = $compra;
        }
        return $compras;
    }

    public function user_purchases_detail($compraId) {
        $compras=null;
        $flights=null;
        $query = $this->queryList("SELECT vuelo_id FROM vuelo_compra WHERE compra_id = ?", array($compraId));
        foreach ($query[0] as $row) {
            $query2 = $this->queryList("SELECT * FROM vuelo WHERE id = ?", array($row['vuelo_id'])); 
            foreach ($query2[0] as $row2) {           
                $flight = new Flight ($row2['id'], $row2['fecha_salida'], $row2['fecha_llegada'], $row2['capacidad'], $row2['ciudad_origen'], $row2['ciudad_destino'], $row2['pais_origen'], $row2['pais_destino'], $row2['precio']);
                $flights[]=$flight;
            }
        }
        $compras[]=$flights;
        $rooms=null;
        $query3 = $this->queryList("SELECT id_habitacion, desde, hasta FROM habitacion_alquiler WHERE compra_id = ?", array($compraId));
        foreach ($query3[0] as $row3) {
            $query4 = $this->queryList("SELECT * FROM habitacion WHERE id = ?", array($row3['id_habitacion'])); 
            $fechaDesde = $row3['desde'];
            $fechaHasta = $row3['hasta'];
            foreach ($query4[0] as $row4) {           
                $room = new Room ( $row4['id'], $row4['capacidad'], $row4['precio'], $row4['estrellas'], $row4['ciudad'], $row4['pais']);
                $room->setFechaDesde($fechaDesde);
                $room->setFechaHasta($fechaHasta);
                $rooms[]=$room;
            }
        }
        $compras[]=$rooms;
        $cars=null;
        $query5 = $this->queryList("SELECT id_auto, desde, hasta FROM auto_alquiler WHERE compra_id = ?", array($compraId));
        foreach ($query5[0] as $row5) {
            $query6 = $this->queryList("SELECT * FROM auto WHERE id = ?", array($row5['id_auto'])); 
            $fechaDesde = $row5['desde'];
            $fechaHasta = $row5['hasta'];
            foreach ($query6[0] as $row6) {           
                $car = new Car ( $row6['id'], $row6['precio'], $row6['capacidad'], $row6['modelo'], $row6['ciudad'], $row6['pais']);
                $car->setFechaDesde($fechaDesde);
                $car->setFechaHasta($fechaHasta);
                $cars[]=$car;
            }
        }
        $compras[]=$cars;
        return $compras;
    }

        public function purchase_by_id($purchaseId) {
        $compras=null;
        $query = $this->queryList("SELECT * FROM compra WHERE id = ?", array($purchaseId));
        foreach ($query[0] as $row) {
            $compra = new Purchase($row['id'], $row['fecha'], $row['total'], $row['usuario_id']);
            $compras[] = $compra;
        }
        return $compras;
    }
}
?>