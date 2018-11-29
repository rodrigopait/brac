<?php
session_start();
if(!isset($_SESSION['rol'])){
	$_SESSION['rol']=0;
}

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require_once('controller/ResourceController.php');
require_once('model/PDORepository.php');
require_once('model/UserRepository.php');
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
require_once('view/TwigView.php');
require_once('view/Login.php');
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


if(isset($_GET["action"])) {
	$method = $_GET["action"];
    ResourceController::getInstance()->$method();
}else{
    ResourceController::getInstance()->home();
}

