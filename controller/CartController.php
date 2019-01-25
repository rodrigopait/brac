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
            /*echo '<pre>';
            print_r($_SESSION['carrito']);
            echo '</pre>';*/
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

    public function cartPurchaseCheck(){
         try{
            $usuarioId=$_SESSION['user_id'];
            $rol = $_SESSION['rol'];
            $username = $_SESSION['usuario'];
            if ((!empty($_SESSION['carrito']['vuelos']['directos'])) OR (!empty($_SESSION['carrito']['vuelos']['escalas'])) OR !empty($_SESSION['carrito']['rooms'])){
                PurchaseRepository::getInstance()->purchaseAdd($usuarioId);

/*                foreach($_SESSION['cars'] as $key => $value){
                    unset($_SESSION['cars'][$key]);
                    unset($_SESSION['carsFechaDesde'][$key+1]);
                    unset($_SESSION['carsFechaHasta'][$key+1]);
                } 
                foreach($_SESSION['rooms'] as $key2 => $value){
                    unset($_SESSION['rooms'][$key2]);
                    unset($_SESSION['roomsFechaDesde'][$key2+1]);
                    unset($_SESSION['roomsFechaHasta'][$key2+1]);
                }*/
/*                foreach($_SESSION['flights'] as $key3 => $value){
                    unset($_SESSION['flights'][$key3]);
                }*/
                $_SESSION['carrito']['vuelos']['directos'] = [];
                $_SESSION['carrito']['directos']['datos'] = [];
                $_SESSION['carrito']['vuelos']['escalas'] = [];
                $_SESSION['carrito']['escalas']['datos'] = [];

                $response = new stdClass();
                $response->data='Comprado';
                $response->id=$usuarioId;
                $data[]=$response;
                echo (json_encode($data)); 

            }
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }
/**
    ALTA  DE VUELOS A CARRITO
**/
    public function addFlightToCart(){
        try{
            $id_vuelo = $_POST['id'];
            $rol = $_SESSION['rol'];
            $data=array();
            if ($rol != '') {
                CartRepository::getInstance()->addFlight($id_vuelo);
                $response = new stdClass();
                $response->data='Agregado';
                $data[]=$response;
                echo (json_encode($data));
            }else{
                $response=new stdClass();
                $response->data='Denegado';
                $data[]=$response;
                echo (json_encode($data));
            }

        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    /**
        BAJA DE VUELOS A CARRITO
    **/
    public function removeFlightFromCart(){
            try{
                $id_flight = $_POST['id'];
                $rol = $_SESSION['rol'];
                if ($rol != '') {
                    CartRepository::getInstance()->removeFlight($id_flight);
                    $response = new stdClass();
                    $response->carrito=$_SESSION['carrito'];
                    $response->data='Eliminado';
                    $data[]=$response;
                    echo (json_encode($data));
                }

            }
            catch (PDOException $e){
                $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
                $view = new Error_display();
                $view->show($error);
            }
        }


    public function addRoomToCart(){
        try{
            $id_room = $_POST['id'];
            $rol = $_SESSION['rol'];
            $fechaDesde = $_POST['fechaDesde'];
            $fechaHasta = $_POST['fechaHasta'];
            $desde = new DateTime($_POST['fechaDesde']);
            $hasta = new DateTime($_POST['fechaHasta']);
            if ($rol != '') {
            CartRepository::getInstance()->addRoom($id_room, $desde->format('Y-m-d'), $hasta->format('Y-m-d'));
            $response = new stdClass();
                $response->session=$_SESSION['carrito']['rooms'];
                $response->data='Agregado';
                $data[]=$response;
                echo (json_encode($data));
            }else{
                $response=new stdClass();
                $response->data='Denegado';
                $data[]=$response;
                echo (json_encode($data));
            }
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

    



    public function removeRoomFromCart(){
        try{
            $id_room = $_POST['id'];
            $rol = $_SESSION['rol'];
            if ($rol != '') {
                CartRepository::getInstance()->removeRoom($id_room);
                $response = new stdClass();
                $response->session=$_SESSION['carrito']['rooms'];
                $response->data='Eliminado';
                $data[]=$response;
                echo (json_encode($data));
            }
             
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

    public function validate(){
        try{
            $usuario=$_SESSION['user_id'];
            $valorTarjeta=$_POST['tarjeta'];
            
            $tarjeta=UserRepository::getInstance()->tarjetaUsuario($usuario);
            $ultimos=explode('-',$tarjeta);
            $miTarjeta = $ultimos[3];
            
            if ($miTarjeta == $valorTarjeta) {
                $response = new stdClass();
                $response->data='Correcto';
                $response->tarjeta=$miTarjeta;
                $data[]=$response;
                echo (json_encode($data));
            }
            else{
                $response = new stdClass();
                $response->data='Incorrecto';
                $response->tarjeta=$miTarjeta;
                $data[]=$response;
                echo (json_encode($data));
            }



        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

}