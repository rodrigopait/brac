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
           $rol=$_GET['rol'];
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
<<<<<<< HEAD
           $this->home();
=======
           $message="La cuenta ha sido eliminada de manera permanente.";
           $view = new Home();
           $view->show($message);
>>>>>>> d9fe05e83f97b2e899fb8181df563807f335ba28
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
           $tarjeta = $_POST['tarjeta'];
           if (isset($usuario) and isset($clave) and isset($nombre) and isset($apellido) and isset($email) and isset($tarjeta)){

               UserRepository::getInstance()->user_add($usuario, $clave, $nombre, $apellido, $email,$tarjeta);
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

   public function userInformation($user_id=null){
       try{
           $rol = $_SESSION['rol'];
           if (!empty($user_id)) {
             $users = UserRepository::getInstance()->listAllByRol(3);
             $view = new UsersList();
             $view->show($rol, $users);
           }else{
             $userId = $_SESSION['user_id'];
             $user= UserRepository::getInstance()->user_information($userId);
             $lastTwo = substr($user->getNumeroTarjeta(),-4);
             $card = 'xxxx-xxxx-xxxx-'.$lastTwo;
             $user->setNumeroTarjeta($card);
             $view = new UserInformation();
             $view->show($rol, $user);
          }
       }
       catch (PDOException $e){
           $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
           $view = new Error_display();
           $view->show($error);        }
   }

   public function userInformationModify(){
       try{
           $rol = $_SESSION['rol'];
            
           if (isset($_GET['id'])) {
                $userId = $_GET['id'];
           }
           else{
              $userId = $_SESSION['user_id'];
           }
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
           if ($rol == 'administrador') {
             $userId = $_POST['userId'];
             $dni = $_POST['dni'];
             $tarjeta = 'null';
           }
           else{
              $userId = $_SESSION['user_id'];
              $tarjeta = $_POST['tarjeta'];
              $dni = 'null';

           }
           $usuario = $_POST['usuario'];
           $clave = $_POST['clave'];
           $nombre = $_POST['nombre'];
           $apellido = $_POST['apellido'];
           $email = $_POST['email'];

           if (isset($usuario) and isset($clave) and isset($nombre) and isset($apellido) and isset($email)){
               UserRepository::getInstance()->user_information_modify($userId, $usuario, $clave, $nombre, $apellido, $email,$tarjeta,$dni);
               if ($rol == 'administrador') {
                  $this->userInformation($userId);
               }
               else{
                  $this->userInformation();
               }
               
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

<<<<<<< HEAD
   public function login_user_check()
   {
     $rol = $_SESSION['rol'];
     $usuario = $_POST['usuario'];
     $clave = $_POST['clave'];

     if(isset($usuario) && isset($clave))
     {
       $user = UserRepository::getInstance()->user_login($usuario, $clave);
        if($user != null)
        {
            $view = new IndexUser();
            $view->show($rol, $user);


        }else {
          echo "Usuario NO existe";die;
        }
     }
   }


}
=======
   public function userComercialCreate(){
    try{
        $rol = $_SESSION['rol'];
        $view = new UserComercialCreate();
        $view->show($rol);
    }
    catch (PDOException $e){
        $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
        $view = new Error_display();
        $view->show($error);
    }
  }

  public function userComercialAdd(){
      $nombre = $_POST['nombre'];
      $apellido= $_POST['apellido'];
      $usuario = $_POST['usuario'];
      $email = $_POST['email'];
      $clave = $_POST['clave'];
      $dni = $_POST['dni'];


      if (!empty($nombre)  && !empty($apellido)  && !empty($usuario) && !empty($email) && !empty($clave) && !empty($dni)){
          $data=array($usuario,$clave,$nombre,$apellido, $dni,$email,3);
          UserRepository::getInstance()->userComercialAdd($data);
          $view = new Home();
          $view->show();
      }else{
          $view = new Home ();
          $view->show();
      }
  }

}
>>>>>>> d9fe05e83f97b2e899fb8181df563807f335ba28
