<?php

class CarController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function carSearch(){
        try{
            $rol = $_SESSION['rol'];
            $view = new CarSearch();
            $view->show($rol);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function carsList(){
        try{
            $ciudadDestino = $_POST['ciudadDestino'];
            $paisDestino = $_POST['paisDestino'];
            $capacidad = $_POST['capacidad'];
            $rol = $_SESSION['rol'];
            $desde = new DateTime($_POST['fechaDesde']);
            $hasta = new DateTime($_POST['fechaHasta']);
            $fechaDesde = $desde->format('Y-m-d');
            $fechaHasta = $hasta->format('Y-m-d');
            $cars = CarRepository::getInstance()->listFromSearch($fechaDesde, $fechaHasta, $capacidad, $ciudadDestino, $paisDestino);
            $view = new CarsList();
            $view->show($rol, $cars, $desde->format('Y-m-d'), $hasta->format('Y-m-d'));
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function carCreate(){
        try {
            $rol = $_SESSION['rol'];
            $view = new CarCreate();
            $view->show($rol);
        } catch (PDOException $e) {
            $error = "Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

}