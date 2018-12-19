<?php

class ConfigurationRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }


    public function list()
    {
    	$query = $this->queryList("SELECT * FROM configuracion WHERE id=?", array(1));
    	$config = $query[0]->fetch(PDO::FETCH_ASSOC);
    	$configuracion = new Configuration($config['id'],$config['gap_max'], $config['descuento_escala'],$config['precio_puntos'],$config['precio_peso'],$config['porcentaje_devolucion'],$config['intentos_sesion'],$config['precio_ejecutiva'],$config['precio_primera']);
    	return $configuracion;
    }

    public function configurationAdd($data)
    {
    	 $this->queryList("UPDATE configuracion SET gap_max=?, descuento_escala=?, precio_puntos=?, precio_peso=?, porcentaje_devolucion=? , intentos_sesion=? , precio_ejecutiva=? , precio_primera=? WHERE id = ?", $data);

    }


}