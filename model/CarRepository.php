<?php

class CarRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    // public function listAll() {

    //     $query = RoomRepository::getInstance()->queryList("SELECT * FROM habitacion", array());
    //     foreach ($query[0] as $row) {
    //         $flight = new Flight ( $row['id'], $row['fecha_salida'], $row['fecha_llegada'], $row['capacidad'], $row['ciudad_origen'], $row['ciudad_destino'], $row['pais_origen'], $row['pais_destino'], $row['precio']);
    //         $flights[]=$flight;
    //     }
    //     $query = null;
    //     return $flights;
    // }

    public function listFromSearch($fechaDesde, $fechaHasta, $capacidad, $ciudadDestino, $paisDestino) {

        $cars = null;
        $sql = "SELECT auto.id as id, 
                    ciudad.nombre as ciudad, 
                    precio, 
                    gama, 
                    modelo.descripcion as modelo,
                    marca.descripcion as marca,
                    capacidad,
                    patente,
                    autonomia,
                    pais.nombre as pais
                FROM auto
                    INNER JOIN ciudad ON auto.ciudad_id = ciudad.id
                    INNER JOIN pais ON ciudad.pais_id = pais.id
                    INNER JOIN modelo ON auto.modelo_id = modelo.id
                    INNER JOIN marca ON modelo.marca_id = marca.id
                WHERE 
                    auto.capacidad >= ? 
                    AND ciudad.id = ? 
                    AND pais.id = ? 
                    AND auto.id NOT IN (SELECT id_auto 
                                    FROM auto_alquiler 
                                    WHERE (desde BETWEEN ? AND ?) 
                                        OR (hasta BETWEEN ? AND ?) 
                                        OR (desde < ? AND hasta > ?))
                ORDER BY auto.precio";
        $query = RoomRepository::getInstance()->queryList($sql, array($capacidad, $ciudadDestino, $paisDestino, $fechaDesde, $fechaHasta, $fechaDesde, $fechaHasta, $fechaDesde, $fechaHasta));
        foreach ($query[0] as $row) {
            $car = new Car ( $row['id'], 
                            $row['ciudad'], 
                            $row['precio'], 
                            $row['gama'], 
                            $row['modelo'], 
                            $row['marca'], 
                            $row['capacidad'], 
                            $row['patente'], 
                            $row['autonomia'], 
                            $row['pais']);
            $cars[]=$car;
        }

        $query = null;
        return $cars;
    }

    //agrego un auto 
    public function carAdd($data) {
        $query = $this->queryList("INSERT INTO auto (ciudad_id,precio,gama,modelo_id,capacidad,patente,autonomia,concesionaria_id) VALUES (?,?,?,?,?,?,?,?)",$data);
    }

    public function brandsAll()
    {
        $query = $this->queryList("SELECT * FROM marca", array());
        $brands=array();
        foreach ($query[0] as $row) {
            $brand =  new stdClass();
            $brand->id = $row['id'];
            $brand->descripcion = utf8_encode($row['descripcion']);
            $brands[]=$brand;
        }


        return $brands;
    }

    public function modelsFrom($idBrand)
    {
        

        $query = $this->queryList("SELECT * FROM modelo WHERE marca_id = ? ORDER BY descripcion", array($idBrand));
        $models=array();
        foreach ($query[0] as $row) {
            $model =  new stdClass();
            $model->id = $row['id'];
            $model->descripcion = utf8_encode($row['descripcion']);
            $models[]=$model;
        }


        return json_encode($models);
    }

}
?>