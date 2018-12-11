<?php

class DefaultController {

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

    public function userRegistration(){
        try{
            $rol = $_SESSION['rol'];
            $view = new UserRegistration();
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

    public function flightSearch()
    {
      try {
        $rol = $_SESSION['rol'];
        $view = new FlightSearch();
        $view->show($rol);


      } catch (PDOException $e) {
        $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
        $view = new Error_display();
        $view->show($error);
      }
    }

    public function roomSearch()
    {
      try {
        $rol = $_SESSION['rol'];
        $view = new RoomSearch();
        $view->show($rol);


      } catch (PDOException $e) {
        $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
        $view = new Error_display();
        $view->show($error);
      }
    }

}
