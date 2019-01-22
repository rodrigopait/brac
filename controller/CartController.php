<?php

class CartController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function cartList(){
        try{
            $rol = $_SESSION['rol'];
            $cart = CartRepository::getInstance()->listAll();
            $view = new CartList();
            $view->show($rol, $cart);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function cartPurchase(){
        try{
            $rol = $_SESSION['rol'];
            $view = new CartPurchase();
            $view->show($rol);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function cartPurchase_check(){
         try{
            $usuarioId=$_SESSION['user_id'];
            $rol = $_SESSION['rol'];
            $username = $_SESSION['usuario'];
            $cart = CartRepository::getInstance()->listAll();
            if (($_SESSION['cars'] != null) OR ($_SESSION['cars'] != null) OR ($_SESSION['cars'] != null)){
                PurchaseRepository::getInstance()->purchase_add($usuarioId, $cart);
                foreach($_SESSION['cars'] as $key => $value){
                    unset($_SESSION['cars'][$key]);
                    unset($_SESSION['carsFechaDesde'][$key+1]);
                    unset($_SESSION['carsFechaHasta'][$key+1]);
                } 
                foreach($_SESSION['rooms'] as $key2 => $value){
                    unset($_SESSION['rooms'][$key2]);
                    unset($_SESSION['roomsFechaDesde'][$key2+1]);
                    unset($_SESSION['roomsFechaHasta'][$key2+1]);
                }
                foreach($_SESSION['flights'] as $key3 => $value){
                    unset($_SESSION['flights'][$key3]);
                }
                $compras= PurchaseRepository::getInstance()->user_purchases($usuarioId);
                $view = new UserPurchases();
                $view->show($compras, $rol, $username);
            }else{
                $view = new Home ();
                $view->show();
            }
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function add_flight_to_cart(){
        try{
            $id_vuelo = $_GET['id'];
            $rol = $_SESSION['rol'];
            $flight=FlightRepository::getInstance()->flightSearchById($id_vuelo);
            CartRepository::getInstance()->addFlight($flight);
            $cart = CartRepository::getInstance()->listAll();
            $view = new CartList();
            $view->show($rol, $cart);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function add_car_to_cart(){
        try{
            $id_auto = $_GET['id'];
            $rol = $_SESSION['rol'];
            $fechaDesde = $_GET['fechaDesde'];
            $fechaHasta = $_GET['fechaHasta'];
            $desde = new DateTime($_GET['fechaDesde']);
            $hasta = new DateTime($_GET['fechaHasta']);
            CartRepository::getInstance()->addCar($id_auto, $desde->format('Y-m-d'), $hasta->format('Y-m-d')); 
            $cart = CartRepository::getInstance()->listAll();
            $view = new CartList();
            $view->show($rol, $cart);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function add_room_to_cart(){
        try{
            $id_room = $_GET['id'];
            $rol = $_SESSION['rol'];
            $fechaDesde = $_GET['fechaDesde'];
            $fechaHasta = $_GET['fechaHasta'];
            $desde = new DateTime($_GET['fechaDesde']);
            $hasta = new DateTime($_GET['fechaHasta']);
            CartRepository::getInstance()->addRoom($id_room, $desde->format('Y-m-d'), $hasta->format('Y-m-d'));
            $cart = CartRepository::getInstance()->listAll();
            $view = new CartList();
            $view->show($rol, $cart); 
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function remove_flight_from_cart(){
        try{
            $id_flight = $_GET['id'];
            $rol = $_SESSION['rol'];
            CartRepository::getInstance()->removeFlight($id_flight);
            $cart = CartRepository::getInstance()->listAll();
            $view = new CartList();
            $view->show($rol, $cart);  
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function remove_room_from_cart(){
        try{
            $id_room = $_GET['id'];
            $rol = $_SESSION['rol'];
            CartRepository::getInstance()->removeRoom($id_room);
            $cart = CartRepository::getInstance()->listAll();
            $view = new CartList();
            $view->show($rol, $cart);  
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function remove_car_from_cart(){
        try{
            $id_car = $_GET['id'];
            $rol = $_SESSION['rol'];
            CartRepository::getInstance()->removeCar($id_car);
            $cart = CartRepository::getInstance()->listAll();
            $view = new CartList();
            $view->show($rol, $cart);  
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

}