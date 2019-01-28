<?php

class RoomRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {

    }

    public function listAll() {
        $sql = "SELECT habitacion.id as habitacion_id,
                    habitacion.capacidad as capacidad, 
                    habitacion.precio as precio, 
                    habitacion.hotel_id as hotel_id, 
                    hotel.nombre as hotel_nombre, 
                    hotel.ciudad_id as hotel_ciudad_id,
                    hotel.estrellas as hotel_estrellas,
                    ciudad.nombre as ciudad,
                    pais.nombre as pais
                FROM habitacion
                    INNER JOIN hotel ON habitacion.hotel_id = hotel.id
                    INNER JOIN ciudad ON hotel.ciuad_id = ciudad.id
                    INNER JOIN pais ON pais.id = ciudad.pais_id";
        $query = RoomRepository::getInstance()->queryList($sql, array());
        foreach ($query[0] as $row) {
            $hotel = new Hotel ($row['hotel_id'],
                                $row['hotel_nombre'],
                                $row['hotel_ciudad_id'],
                                $row['hotel_estrellas']);
            $room = new Room ( $row['habitacion_id'], 
                                $row['capacidad'], 
                                $row['precio'],
                                $hotel, 
                                $row['ciudad'], 
                                $row['pais']);
            $rooms[]=$room;
        }
        $query = null;
        return $rooms;
    }

    public function listFromSearch($fechaDesde, $fechaHasta, $estrellas, $ciudadDestino, $paisDestino, $capacidad) {

        $rooms=null;
        $sql = "SELECT habitacion.id as habitacion_id,
                        habitacion.capacidad as capacidad, 
                        habitacion.precio as precio, 
                        habitacion.hotel_id as hotel_id, 
                        hotel.nombre as hotel_nombre, 
                        hotel.ciudad_id as hotel_ciudad_id,
                        hotel.estrellas as hotel_estrellas,
                        ciudad.nombre as ciudad,
                        pais.nombre as pais
                FROM habitacion
                    INNER JOIN hotel ON habitacion.hotel_id = hotel.id
                    INNER JOIN ciudad ON hotel.ciudad_id = ciudad.id
                    INNER JOIN pais ON ciudad.pais_id = pais.id
                WHERE hotel.estrellas >= ?
                    AND hotel.ciudad_id = ? 
                    AND ciudad.pais_id = ? 
                    AND habitacion.capacidad >= ? 
                    AND habitacion.id NOT IN (SELECT id_habitacion 
                                    FROM habitacion_alquiler 
                                    WHERE (desde BETWEEN ? AND ?) 
                                        OR (hasta BETWEEN ? AND ?) 
                                        OR (desde < ? AND hasta > ?))
                ORDER BY habitacion.precio";
        $query = RoomRepository::getInstance()->queryList($sql, array($estrellas, $ciudadDestino, $paisDestino, $capacidad, $fechaDesde, $fechaHasta, $fechaDesde, $fechaHasta, $fechaDesde, $fechaHasta));
        foreach ($query[0] as $row) {
            $hotel = new Hotel ($row['hotel_id'],
                                utf8_encode($row['hotel_nombre']),
                                utf8_encode($row['hotel_ciudad_id']),
                                $row['hotel_estrellas']);
            $room = new Room ( $row['habitacion_id'], 
                                $row['capacidad'], 
                                $row['precio'],
                                $hotel, 
                                utf8_encode($row['ciudad']), 
                                utf8_encode($row['pais']));
            $rooms[]=$room;
        }

        $query = null;
        return $rooms;
    }

        //agrego un habitacion
    public function roomAdd($data) {
        $query = $this->queryList("INSERT INTO habitacion (capacidad, precio, hotel_id) VALUES (?,?,?)",$data);
    }

    public function duplicity($hotel,$precio,$capacidad) {
        $sql = "SELECT count(id) as cantidad FROM habitacion WHERE hotel_id = ? AND precio = ? AND capacidad = ?";
        $query = $this->queryList($sql,array($hotel,$precio,$capacidad));
        $rooms=0;
        foreach ($query[0] as $row) {
            $rooms=$row['cantidad'];
        }
        return $rooms;
    }
}
?>
