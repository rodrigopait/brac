<?php

class ResourceController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    public function home(){
        try{
            $rol = $_SESSION['rol'];
            $view = new Home();
            $view->show($rol);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function login(){
        try{
            $rol = $_SESSION['rol'];
            $view = new Login();
            $view->show($rol);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function logout(){
        try{
            $model= UserRepository::getInstance()->logout_user();
            ResourceController::getInstance()->home();
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }    
  
    public function login_user_check(){
        try{
            $model = UserRepository::getInstance()->login_user();
            /*$model= UserRepository::getInstance()->logout_user();
            if (isset($_SESSION['rol'])){
                ResourceController::getInstance()->home();
            }
            else{
                $view = new Login();
                $view->show();  
            }*/
            $view = new Home();
            $view->show();  
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

    public function flightsListAll(){
        try{
            $rol = $_SESSION['rol'];
            $flights = FlightRepository::getInstance()->listAll($flights);
            $view = new FlightsList();
            $view->show($rol, $flights);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function flightsList(){
        try{
            $rol = $_SESSION['rol'];
            $ciudadOrigen = $_POST['ciudadOrigen'];
            $paisOrigen = $_POST['paisOrigen'];
            $ciudadDestino = $_POST['ciudadDestino'];
            $paisDestino = $_POST['paisDestino'];
            $fechaPartida = new DateTime($_POST['fechaPartida']);
            $fecha = $fechaPartida->format('Y-m-d');
            $flights = FlightRepository::getInstance()->listFromSearch($fecha, $ciudadOrigen, $ciudadDestino, $paisOrigen, $paisDestino);
            $view = new FlightsList(); 
            $view->show($rol, $flights);
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

    public function userPurchases(){
         try{
            $rol = $_SESSION['rol'];
            $userId = $_SESSION['user_id'];
            $username= $_SESSION['usuario'];
            $compras= PurchaseRepository::getInstance()->user_purchases($userId);
            $view = new UserPurchases();
            $view->show($compras, $rol, $username);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function userPurchasesById(){
         try{
            $rol = $_SESSION['rol'];
            $userId = $_GET['userId'];
            $username= $_GET['username'];
            $compras= PurchaseRepository::getInstance()->user_purchases($userId);
            $view = new UserPurchases();
            $view->show($compras, $rol, $username);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }


    public function userPurchasesDetail(){
         try{
            $compraId = $_GET['compraId'];
            $rol = $_SESSION['rol'];
            $compras= PurchaseRepository::getInstance()->purchase_by_id($compraId);
            $comprasDetalle = PurchaseRepository::getInstance()->user_purchases_detail($compraId);
            $view = new UserPurchasesDetail();
            $view->show($compras, $rol, $comprasDetalle);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }


    public function usersList(){
        try{
            $rol = $_SESSION['rol'];
            $users = UserRepository::getInstance()->listAll();
            $view = new UsersList();
            $view->show($rol, $users);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function userRemove(){
        try{
            $userId = $_GET['userId'];
            if (isset($_GET['userId'])) {
                UserRepository::getInstance()->user_remove($userId);
            }
            $this->usersList();  
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function userDelete(){
        try{
            $userId = $_SESSION['user_id'];
            if (isset($_SESSION['user_id'])) {
                UserRepository::getInstance()->user_delete($userId);
                $_SESSION['rol']=0;
                $_SESSION['flights'] = null;
                $_SESSION['rooms'] = null;
                $_SESSION['cars'] = null;
                $_SESSION['carsFechaDesde'] = null;
                $_SESSION['carsFechaHasta'] = null;
                $_SESSION['roomsFechaDesde'] = null;
                $_SESSION['roomsFechaHasta'] = null;
            }
            $this->home();  
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function userRegistration(){
        try{
            $view = new UserRegistration();
            $view->show();
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function userRegistration_check(){
        try{
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            if (isset($usuario) and isset($clave) and isset($nombre) and isset($apellido) and isset($email)){
                UserRepository::getInstance()->user_add($usuario, $clave, $nombre, $apellido, $email);
                $view = new Login();
                $view->show();
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

    public function userInformation(){
        try{
            $rol = $_SESSION['rol'];
            $userId = $_SESSION['user_id'];
            $user= UserRepository::getInstance()->user_information($userId);
            $view = new UserInformation();
            $view->show($rol, $user);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);        }
    }

    public function userInformationModify(){
        try{
            $rol = $_SESSION['rol'];
            $userId = $_SESSION['user_id'];
            $user= UserRepository::getInstance()->user_information($userId);
            $view = new UserInformationModify();
            $view->show($rol, $user);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);        }
    }

    public function userInformationModify_check(){
        try{
            $rol = $_SESSION['rol'];
            $userId = $_SESSION['user_id'];
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            if (isset($usuario) and isset($clave) and isset($nombre) and isset($apellido) and isset($email)){
                UserRepository::getInstance()->user_information_modify($userId, $usuario, $clave, $nombre, $apellido, $email);
                $this->userInformation();
            }else{
                $view = new Home ();
                $view->show();
            }
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);        }
    }

    public function add_flight_to_cart(){
        try{
            $id_vuelo = $_GET['id'];
            $rol = $_SESSION['rol'];
            CartRepository::getInstance()->addFlight($id_vuelo);
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
