<?php

class FlightController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function flightsListAll(){
        try{
            $rol = $_SESSION['rol'];
            $flights = FlightRepository::getInstance()->listAll();
            $view = new FlightsList();
            $view->show($rol, $flights);
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
            $clases = ClaseRepository::getInstance()->listAll();
            $view = new FlightSearch($clases);
            $view->show($clases);
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
            $ciudadDestino = $_POST['ciudadDestino'];
            $fechaPartida = new DateTime($_POST['fechaPartida']);
            $fecha = $fechaPartida->format('Y-m-d');
            $escalas = $_POST['escalas'];

            $idclase = $_POST['clase'];
            $clase = ClaseRepository::getInstance()->getClase($idclase);

            #var_dump($idclase);die;
            if($idClase = 1)
            {
                $flights = FlightRepository::getInstance()->listFromSearchByClase1($fecha, $ciudadOrigen, $ciudadDestino, $escalas);  

            }else
            {
                if($idClase = 2)
                {
                $flights = FlightRepository::getInstance()->listFromSearchByClase2($fecha, $ciudadOrigen, $ciudadDestino, $escalas);    
                }else 
                {
                    if($idClase = 3)
                    {
                    $flights = FlightRepository::getInstance()->listFromSearchByClase3($fecha, $ciudadOrigen, $ciudadDestino, $escalas);    
                    }
                }    
            }
            

            

            $view = new FlightsList(); 
            $view->show($rol, $flights,$clase);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function flightCreate(){
        try{
            $rol = $_SESSION['rol'];
            $paises = CountryRepository::getInstance()->listAll();
            $airlines = AirlineRepository::getInstance()->listAll();
            $view = new FlightCreate();
            $view->show($rol,$airlines,$paises);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function flightAdd()
    {
        $ciudadOrigen = $_POST['ciudadOrigen'];
        $ciudadDestino = $_POST['ciudadDestino'];
        $aerolinea = $_POST['aerolinea'];
        $fechaPartida = $_POST['fechaPartida'];
        $precio = $_POST['precio'];
        $economica = $_POST['economica'];
        $ejecutiva = $_POST['ejecutiva'];
        $primera = $_POST['primera'];
        $hora = $_POST['hora'];
        $duracion = $_POST['duracion'];

        if(!empty($ciudadOrigen) && !empty($ciudadDestino) && !empty($aerolinea) && !empty($fechaPartida) && !empty($precio) && !empty($economica) && !empty($ejecutiva) && !empty($primera) && !empty($hora) && !empty($duracion)) {
                /*$data=array($ciudad,$precio,$gama, $modelo,$capacidad,$patente, $autonomia,$concesionaria);
                CarRepository::getInstance()->carAdd($data);
                $view = new Home();
                $view->show();*/
                $fechaSalida= $fechaPartida.' '.$hora;
                $fechaLLegada =date('Y-m-d H:i:s', strtotime($fechaSalida.' + '.$duracion.' hours'));
                $data=array($fechaSalida,$fechaLLegada,$ciudadOrigen,$ciudadDestino,$precio,$economica,$ejecutiva,$primera,$aerolinea);
                FlightRepository::getInstance()->flightAdd($data);
                $view = new Home();
                $view->show();
        }
        else{
            $view = new Home();
            $view->show();
        }
    }
}