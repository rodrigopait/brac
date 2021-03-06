<?php
session_start();
if(!isset($_SESSION['rol'])){
	$_SESSION['rol']='';
}

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
date_default_timezone_set('America/Argentina/Buenos_Aires');

require_once('controller/DefaultController.php');
require_once('controller/FlightController.php');
require_once('controller/RoomController.php');
require_once('controller/CarController.php');
require_once('controller/UserController.php');
require_once('controller/CartController.php');
require_once('controller/LoginController.php');
require_once('controller/HotelController.php');
require_once('controller/AirlineController.php');
require_once('controller/ConcessionaireController.php');
require_once('controller/ConfigurationController.php');
require_once('controller/CityController.php');
require_once('model/PDORepository.php');
require_once('model/UserRepository.php');
require_once('model/ClaseRepository.php');
require_once('model/User.php');
require_once('model/CartRepository.php');
require_once('model/Cart.php');
require_once('model/FlightRepository.php');
require_once('model/Flight.php');
require_once('model/RoomRepository.php');
require_once('model/Room.php');
require_once('model/CarRepository.php');
require_once('model/PurchaseRepository.php');
require_once('model/Purchase.php');
require_once('model/Car.php');
require_once('model/Concessionaire.php');
require_once('model/ConcessionaireRepository.php');
require_once('model/AirlineRepository.php');
require_once('model/Airline.php');
require_once('model/HotelRepository.php');
require_once('model/Hotel.php');
require_once('model/CountryRepository.php');
require_once('model/Country.php');
require_once('model/CityRepository.php');
require_once('model/City.php');
require_once('model/ConfigurationRepository.php');
require_once('model/Configuration.php');
require_once('view/TwigView.php');
require_once('view/Login.php');
require_once('model/Clase.php');
require_once('view/Home.php');
require_once('view/CarsList.php');
require_once('view/CarSearch.php');
require_once('view/FlightsList.php');
require_once('view/FlightSearch.php');
require_once('view/RoomSearch.php');
require_once('view/RoomsList.php');
require_once('view/CartList.php');
require_once('view/CartPurchase.php');
require_once('view/UserPurchases.php');
require_once('view/UserPurchasesDetail.php');
require_once('view/UsersList.php');
require_once('view/UserRegistration.php');
require_once('view/UserInformation.php');
require_once('view/UserInformationModify.php');
require_once('view/HotelCreate.php');
require_once('view/ConcessionaireCreate.php');
require_once('view/ConcessionairesList.php');
require_once('view/AirlineCreate.php');
require_once('view/UserComercialCreate.php');
require_once('view/FlightCreate.php');
require_once('view/CarCreate.php');
require_once('view/RoomCreate.php');
require_once('view/ConfigurationList.php');
require_once('model/Pregunta.php');
require_once('model/PreguntaRepository.php');
require_once('view/UserRecovery.php');


if(isset($_GET["method"]) & isset($_GET["controller"]) ) {
    $method = $_GET["method"];
    $controller = $_GET["controller"]."Controller";
    $parameters = null;
    if (isset($_GET['parameters'])) {
        $parameters = $_GET['parameters'];
    }
    $controller::getInstance()->$method($parameters);
}else{
    DefaultController::getInstance()->home();
}
