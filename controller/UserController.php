<?php

class UserController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
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
           $rol = $_GET['rol'];
           $users = UserRepository::getInstance()->listAllByRol($rol);
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

}