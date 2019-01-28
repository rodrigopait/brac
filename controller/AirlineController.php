<?php

class AirlineController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function airlineCreate(){
        try{
            $rol = $_SESSION['rol'];
            $view = new AirlineCreate();
            $view->show($rol);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function airlineAdd(){
        $nombre = $_POST['nombre'];
        if (isset($nombre) && !empty($nombre)){
            AirlineRepository::getInstance()->airlineAdd($nombre,0);         
            $valor=new stdClass();
            $valor->msj='Agregado';
            $info[]=$valor;
            echo (json_encode($info));
        }else{
            $view = new Home ();
            $view->show();
        }
    }

    public function verifyDuplicity()
    {
        $airline = $_POST['airline'];
        $cant = AirlineRepository::getInstance()->duplicity($airline);
        echo($cant);
    }
}