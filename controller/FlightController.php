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
            $paises = CountryRepository::getInstance()->listAll();
            #var_dump($paises);die;
            $view = new FlightSearch();
            $view->show($rol,$clases,$paises);
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

            $ciudadOrigen=$_POST['ciudadOrigen'];
            $ciudadDestino=$_POST['ciudadDestino'];
            $fechaPartida = new DateTime($_POST['fechaPartida']);
            $fecha = $fechaPartida->format('Y-m-d');
            $clase = $_POST['clase'];
            $pasajeros = $_POST['pasajeros'];

            if (!empty($ciudadOrigen) && !empty($ciudadDestino)  && !empty($fecha)  && !empty($clase) && !empty($pasajeros)) {
                
                $fecha_desde=$fecha.' 00:00:00';
                $fecha_hasta=$fecha.' 23:59:59';

                $origen=  (CityRepository::getInstance()->cityName($ciudadOrigen));
                $destino= (CityRepository::getInstance()->cityName($ciudadDestino));

                $flights=FlightRepository::getInstance()->flightSearch($destino,$fecha_desde,$fecha_hasta,$origen,$pasajeros,$clase);
                
                $view = new FlightsList();
                if ($rol == '') {
                    $carrito=null;
                }
                else{
                    $carrito=$_SESSION['carrito']['vuelos'];
                }
                $view->show($rol, $flights, $carrito);
            }
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
                $origen= CityRepository::getInstance()->cityName($ciudadOrigen);
                $destino= CityRepository::getInstance()->cityName($ciudadDestino);
                $fechaSalida= $fechaPartida.' '.$hora;

                $tiempo=explode(':',$duracion);
                $hora=$tiempo[0];
                $minutos=$tiempo[1];
                $fechaLLegada =date('Y-m-d H:i', strtotime($fechaSalida.' + '.$hora.' hours '.$minutos.' minutes'));
                $data=array($fechaSalida,$fechaLLegada,$origen,$destino,$precio,$economica,$ejecutiva,$primera,$aerolinea);
                FlightRepository::getInstance()->flightAdd($data);

                $valor=new stdClass();
                $valor->msj='Agregado';
                $info[]=$valor;
                echo (json_encode($info));
        }
        else{
            $view = new Home();
            $view->show();
        }
    }
}
