<?php

class ConfigurationController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    public function index(){
        try{
            $rol = $_SESSION['rol'];
            $configuration=ConfigurationRepository::getInstance()->listConf();
            $view = new ConfigurationList();
            $view->show($rol,$configuration);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function configurationAdd()
    {
        $gap=$_POST['gap'];
        $descuento=$_POST['descuento'];
        $precioPuntos=$_POST['precioPuntos'];
        $precioPeso=$_POST['precioPeso'];
        $devolucion=$_POST['devolucion'];
        $intentos=$_POST['intentos'];
        $precioEjecutiva=$_POST['precioEjecutiva'];
        $precioPrimera=$_POST['precioPrimera'];

        if (!empty($gap) && !empty($descuento) && !empty($precioPuntos) && !empty($precioPeso) && !empty($devolucion) && !empty($intentos) && !empty($precioEjecutiva) && !empty($precioPrimera)) {
            $data = array($gap,$descuento,$precioPuntos,$precioPeso,$devolucion,$intentos,$precioEjecutiva,$precioPrimera,1);
            ConfigurationRepository::getInstance()->configurationAdd($data);
            $rol=$_SESSION['rol'];
            $view = new Home();
            $view->show();

        }
    }

}