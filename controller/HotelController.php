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
            $view = new HotelCreate();
            $view->show($rol);
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
        $pais = $_POST['pais'];

        if (isset($nombre) && !empty($nombre)){
            HotelRepository::getInstance()->hotelAdd($nombre,$ciudad,$pais,0);
            $view = new Home();
            $view->show();
        }else{
            $view = new Home ();
            $view->show();
        }
    }
}