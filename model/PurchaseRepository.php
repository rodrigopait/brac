<?php

class PurchaseRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function purchase_add($usuarioId, $cart) {

        $total = 0;
        foreach ($_SESSION['flights'] as $flightId) {
            $precioVuelo = FlightRepository::getInstance()->queryList("SELECT precio FROM vuelo WHERE id = ?", array($flightId));
            foreach ($precioVuelo[0] as $row) {
                $total += $row['precio'];
            }
        }

        foreach ($_SESSION['rooms'] as $roomId) {
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

        $query = $this->queryList("INSERT INTO compra (total, usuario_id) VALUES (?,?)", array($total, $usuarioId));
        $compra_id = $query[1];

        foreach ($_SESSION['flights'] as $flightId) {
            $this->queryList("INSERT INTO vuelo_compra (vuelo_id, compra_id) VALUES (?,?)", array($flightId, $compra_id));
            $this->queryList("UPDATE vuelo SET capacidad=capacidad-1 WHERE id = ?", array($flightId));
        }

        foreach ($_SESSION['rooms'] as $index => $value) {
            $this->queryList("INSERT INTO habitacion_alquiler (desde, hasta, id_habitacion, compra_id) VALUES (?,?,?,?)", array($_SESSION['roomsFechaDesde'][$index+1], $_SESSION['roomsFechaHasta'][$index+1], $_SESSION['rooms'][$index], $compra_id));
        }

        foreach ($_SESSION['cars'] as $index => $value) {
            $this->queryList("INSERT INTO auto_alquiler (desde, hasta, id_auto, compra_id) VALUES (?,?,?,?)", array($_SESSION['carsFechaDesde'][$index+1], $_SESSION['carsFechaHasta'][$index+1], $_SESSION['cars'][$index], $compra_id));
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