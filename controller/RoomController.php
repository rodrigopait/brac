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
            $paises = CountryRepository::getInstance()->listAll();
            $view = new RoomSearch();
            $view->show($rol,$paises);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function roomCreate($message = null){
        try {
            $rol = $_SESSION['rol'];
            $paises = CountryRepository::getInstance()->listWithRoom();
            $view = new RoomCreate();
            $view->show($rol,$paises,$message);
        } catch (PDOException $e) {
            $error = "Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
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
            $estrellas = $_POST['estrellas'];
            $ciudadDestino = $_POST['ciudadDestino'];
            $paisDestino = $_POST['paisDestino'];
            $capacidad = $_POST['personas'];
            $desde = new DateTime($_POST['fechaDesde']);
            $hasta = new DateTime($_POST['fechaHasta']);
            $fechaDesde = $desde->format('Y-m-d');
            $fechaHasta = $hasta->format('Y-m-d');
            // var_dump($estrellas, $ciudadDestino, $paisDestino, $capacidad, $fechaDesde, $fechaHasta, $fechaDesde, $fechaHasta, $fechaDesde, $fechaHasta);die;
            $rooms = RoomRepository::getInstance()->listFromSearch($fechaDesde, $fechaHasta, $estrellas, $ciudadDestino, $paisDestino, $capacidad);
            $view = new RoomsList(); 
             if ($rol == '') {
                    $rooms_carrito=null;
                }
                else{
                    $rooms_carrito=$_SESSION['carrito']['rooms'];
                }
            $view->show($rol, $rooms, $fechaDesde, $fechaHasta, $rooms_carrito);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function roomAdd(){
        $precio= $_POST['precio'];
        $capacidad = $_POST['capacidad'];
        $hotel = $_POST['hotel'];
        if (!empty($precio) && !empty($capacidad) && !empty($hotel)){
            $data=array($capacidad,$precio,$hotel);
            RoomRepository::getInstance()->roomAdd($data);
  /*          RoomController::getInstance()->roomsListAll();*/

            $valor=new stdClass();
            $valor->msj='Agregado';
            $info[]=$valor;
            echo (json_encode($info));
        }else{
            var_dump('entro aca');
            $message = 'No se pudo agregar la habitacion';
            RoomController::getInstance()->roomCreate($message);
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

    public function verifyDuplicity()
    {
        $hotel = $_POST['hotel'];
        $precio = $_POST['precio'];
        $capacidad = $_POST['capacidad'];
        $cant = RoomRepository::getInstance()->duplicity($hotel,$precio,$capacidad);
        echo($cant);
    }

}
