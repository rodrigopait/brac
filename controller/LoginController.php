<?php

class LoginController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {

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
            DefaultController::getInstance()->home();
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function login_user_check(){
        try{

          $username = $_POST['usuario'];
          $password = $_POST['clave'];

          if(!is_null($username) AND !is_null($password)){
            if($model = UserRepository::getInstance()->login_user($username, $password) != null)
            {
              $view = new Home();
              $view->show();
            }else {
              $view = new Login();
              $view->show();
            }

            /*$model= UserRepository::getInstance()->logout_user();
            if (isset($_SESSION['rol'])){
                DefaultController::getInstance()->home();
            }
            else{
            }*/
        }
      }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

}
