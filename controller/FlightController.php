<?php

class FlightController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function flightsListAll(){
        try{
            $rol = $_SESSION['rol'];
            $flights = FlightRepository::getInstance()->listAll();
            $view = new FlightsList();
            $view->show($rol, $flights);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function flightSearch(){
        try{
            $rol = $_SESSION['rol'];
            $view = new FlightSearch();
            $view->show($rol);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function flightsList(){
        try{
            #var_dump($_POST);die;
            $rol = $_SESSION['rol'];
            $ciudadOrigen = $_POST['ciudadOrigen'];
            $paisOrigen = $_POST['paisOrigen'];
            $ciudadDestino = $_POST['ciudadDestino'];
            $paisDestino = $_POST['paisDestino'];
            $fechaPartida = new DateTime($_POST['fechaPartida']);
            $fecha = $fechaPartida->format('Y-m-d');
            $escalas = $_POST['escalas'];

            $flights = FlightRepository::getInstance()->listFromSearch($fecha, $ciudadOrigen, $ciudadDestino, $paisOrigen, $paisDestino, $escalas);
            $view = new FlightsList(); 
            $view->show($rol, $flights);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }
}