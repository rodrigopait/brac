<?php

class RoomController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function roomSearch(){
        try{
            $rol = $_SESSION['rol'];
            $view = new RoomSearch();
            $view->show($rol);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function roomsListAll(){
        try{
            $rol = $_SESSION['rol'];
            $rooms = RoomRepository::getInstance()->listAll();
            $view = new RoomsList();
            $view->show($rol, $rooms);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function roomsList(){
        try{
            $rol = $_SESSION['rol'];
            $minimoEstrellas = $_POST['minimoEstrellas'];
            $maximoEstrellas = $_POST['maximoEstrellas'];
            $ciudadDestino = $_POST['ciudadDestino'];
            $paisDestino = $_POST['paisDestino'];
            $capacidad = $_POST['capacidad'];
            $desde = new DateTime($_POST['fechaDesde']);
            $hasta = new DateTime($_POST['fechaHasta']);
            $fechaDesde = $desde->format('Y-m-d');
            $fechaHasta = $hasta->format('Y-m-d');
            $rooms = RoomRepository::getInstance()->listFromSearch($fechaDesde, $fechaHasta, $minimoEstrellas, $maximoEstrellas, $ciudadDestino, $paisDestino, $capacidad);
            $view = new RoomsList(); 
            $view->show($rol, $rooms, $desde->format('Y-m-d'), $hasta->format('Y-m-d'));
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function listRoom(){
        try{
            $rol = $_SESSION['rol'];
            $view = new RoomSearch();
            $view->show($rol);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

}