<?php

class CarController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function carSearch(){
        try{
            $rol = $_SESSION['rol'];
            $paises = CountryRepository::getInstance()->listAll();
            $view = new CarSearch();
            $view->show($rol,$paises);
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

    public function carCreate(){
        try {
            $rol = $_SESSION['rol'];
            $paises = CountryRepository::getInstance()->listWithConcessionaries();
            $concesionarias = ConcessionaireRepository::getInstance()->listAll();
            $marcas = CarRepository::getInstance()->brandsAll();
            $view = new CarCreate();
            $view->show($rol,$paises,$marcas,$concesionarias);
        } catch (PDOException $e) {
            $error = "Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function carAdd()
    {
        $ciudad = $_POST['ciudadOrigen'];
        $concesionaria = $_POST['concesionaria'];
        $modelo = $_POST['modelo'];
        $precio = $_POST['precio'];
        $capacidad = $_POST['capacidad'];
        $patente = $_POST['patente'];
        $gama = $_POST['gama'];
        $autonomia = $_POST['autonomia'];

        if(!empty($ciudad) && !empty($concesionaria) && !empty($modelo) && !empty($precio) && !empty($capacidad) && !empty($patente) && !empty($gama) && !empty($autonomia)) {
                $data=array($ciudad,$precio,$gama, $modelo,$capacidad,$patente, $autonomia,$concesionaria);
                CarRepository::getInstance()->carAdd($data);
                $view = new Home();
                $view->show();
        }
        else{
            $view = new Home();
            $view->show();
        }
    }
    public function modelsBrand()
    {
        $idAuto=(int)$_POST['id'];
        $models = CarRepository::getInstance()->modelsFrom($idAuto);
        
        echo ($models);
    }


}