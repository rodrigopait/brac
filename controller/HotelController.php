<?php

class HotelController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function hotelCreate(){
        try{
            $rol = $_SESSION['rol'];
            $paises = CountryRepository::getInstance()->listAll();
            $view = new HotelCreate();
            $view->show($rol,$paises);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function hotelAdd(){
        $nombre = $_POST['nombre'];
        $ciudad= $_POST['ciudad'];
        $estrellas = $_POST['estrellas'];

        if (!empty($nombre)  && !empty($ciudad)   && !empty($estrellas) ){
            HotelRepository::getInstance()->hotelAdd($nombre,$ciudad,$estrellas);
            $view = new Home();
            $view->show();
        }else{
            $view = new Home ();
            $view->show();
        }
    }

    public function hotelsFrom()
    {
        $idCiudad=(int)$_POST['id'];
        $hotels=HotelRepository::getInstance()->listFrom($idCiudad);
        echo ($hotels);

    }


}