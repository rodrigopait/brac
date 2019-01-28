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
           $comprasVigentes= PurchaseRepository::getInstance()->userPurchasesCurrents($userId);
           $comprasCerradas= PurchaseRepository::getInstance()->userPurchasesNotCurrents($userId);
           $view = new UserPurchases();
           $view->show($rol, $username, $comprasVigentes, $comprasCerradas);
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
           $compras= PurchaseRepository::getInstance()->userPurchases($userId);
           $view = new UserPurchases();
           $view->show($rol, $username,$compras);
       }
       catch (PDOException $e){
           $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
           $view = new Error_display();
           $view->show($error);
       }
   }


   public function userPurchasesDetail(){
        try{
           $compraId = $_GET['id'];    
           $rol = $_SESSION['rol'];
           $compra= PurchaseRepository::getInstance()->purchaseById($compraId);
           $compraDetalle = PurchaseRepository::getInstance()->userPurchasesDetail($compraId);
           $canceladas = PurchaseRepository::getInstance()->userPurchasesClosed($compraId);
           $view = new UserPurchasesDetail();
           $config = ConfigurationRepository::getInstance()->listConf();
           $view->show($compra,$rol, $compraDetalle, $canceladas, $config);
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
           $message="La cuenta ha sido eliminada de manera permanente.";
           $view = new Home();
           $view->show($message);
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
           $preguntas = PreguntaRepository::getInstance()->listAll();
           //var_dump($preguntas);die;
           $view->show($preguntas);
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
           $pregunta = $_POST['pregunta'];
           $respuesta = $_POST['respuesta'];

           if (isset($usuario) and isset($clave) and isset($nombre) and isset($apellido) and isset($email) and isset($tarjeta) and isset($pregunta) and isset($respuesta)){

               UserRepository::getInstance()->user_add($usuario, $clave, $nombre, $apellido, $email,$tarjeta,$pregunta,$respuesta);
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

   /*public function preguntasSearch(){
        try{
  
            $preguntas = PreguntaRepository::getInstance()->listAll();
            #var_dump($preguntas);die;
            $view = new UserRegistration();
            $view->show($preguntas);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }*/

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
             $tarjeta = null;
           }
           else{
              $userId = $_SESSION['user_id'];
              $tarjeta = $_POST['tarjeta'];
              $dni = null;

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

   public function login_user_check()
   {
     $rol = $_SESSION['rol'];
     $usuario = $_POST['usuario'];
     $clave = $_POST['clave'];

     if(isset($usuario) && isset($clave))
     {
       $user = UserRepository::getInstance()->login_user($usuario, $clave);
        if($user != null)
        {
            $view = new Home();
            $view->show();


        }else {
          $view = new login();
            $view->show($usuario);
        }
     }
   }

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
          $valor=new stdClass();
          $valor->msj='Agregado';
          $info[]=$valor;
          echo (json_encode($info));
      }else{
          $view = new Home ();
          $view->show();
      }
  }

   

    public function userRecovery(){
       try{
           $username = $_GET['username'];
           if (isset($username)){
               $user = UserRepository::getInstance()->user_information_by_username($username);
               $view = new UserRecovery();
               $view->show($user);
           }else{
               $view = new Login ();
               $view->show();
           }
       }
       catch (PDOException $e){
           $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
           $view = new Error_display();
           $view->show($error);
       }
   }

   public function user_recovery_check(){
       try{
           $user_id = $_POST['user_id'];
           $pregunta= $_POST['pregunta_id'];
           $respuesta = $_POST['respuesta'];
           $username = $_POST['usuario'];
           if (isset($user_id) && isset($pregunta) && isset($respuesta)){
               $info = UserRepository::getInstance()->desbloquear($user_id, $pregunta, $respuesta);
               if($info) {
                  $view = new Login();
                  $view->show();
               } else {
                  $view = new UserRecovery($username);
                 $view->show();
               }
           }else{
               $view = new UserRecovery($username);
               $view->show();
           }
       }
       catch (PDOException $e){
           $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
           $view = new Error_display();
           $view->show($error);
       }
   }

   public function deletePurchaseRoom()
   {
    try{
       $id_room=$_POST['id'];
       $id_compra = $_POST['compraId'];
       $precio = $_POST['precio'];
       PurchaseRepository::getInstance()->deletePurchaseRoom($id_room,$id_compra,$precio);
       $valor=new stdClass();
       $valor->data='eliminado';
       $info[]=$valor;
       echo (json_encode($info));
    }
    catch  (PDOException $e){
      $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
      $view = new Error_display();
      $view->show($error);
    }

   }

   public function deletePurchaseCar()
   {
     try{
        $idCar=$_POST['id'];
        $id_compra = $_POST['compraId'];
        $precio = $_POST['precio'];
        PurchaseRepository::getInstance()->deletePurchaseCar($idCar,$id_compra,$precio);
        $valor=new stdClass();
        $valor->data='eliminado';
        $info[]=$valor;
        echo (json_encode($info));
     }
     catch  (PDOException $e){
       $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
       $view = new Error_display();
       $view->show($error);
     }
   }

   public function deletePurchaseFlight()
   {
     try{
        $id_room=$_POST['id'];
        $id_compra = $_POST['compraId'];
        $precio = $_POST['precio'];
        PurchaseRepository::getInstance()->deletePurchaseFlight($id_room,$id_compra,$precio);
        $valor=new stdClass();
        $valor->data='eliminado';
        $info[]=$valor;
        echo (json_encode($info));
     }
     catch  (PDOException $e){
       $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
       $view = new Error_display();
       $view->show($error);
     }
   }

}
