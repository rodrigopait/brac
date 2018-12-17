<?php

class CityController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }


    public function citiesCountry()
    {
    	$idPais=(int)$_POST['id'];
    	$cities = CityRepository::getInstance()->listFrom($idPais);
    	
    	echo ($cities);
    }

    public function citiesConcessionaire()
    {
        $idPais=(int)$_POST['id'];
        $cities = CityRepository::getInstance()->citiesWithConcessionaire($idPais);
        
        echo ($cities);
    }

}