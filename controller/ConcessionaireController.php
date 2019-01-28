<?php

class ConcessionaireController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function concessionaireCreate(){
        try{
            $rol = $_SESSION['rol'];
            $paises = CountryRepository::getInstance()->listAll();
            $view = new ConcessionaireCreate();
            $view->show($rol,$paises);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function concessionaireAdd(){
        $nombre = $_POST['nombre'];
        $ciudad= $_POST['ciudad'];

        if (isset($nombre) && !empty($nombre) && !empty($ciudad)){
            ConcessionaireRepository::getInstance()->concessionaireAdd($nombre,$ciudad,0);
            $valor=new stdClass();
            $valor->msj='Agregado';
            $info[]=$valor;
            echo (json_encode($info));
        }else{
            $view = new Home ();
            $view->show();
        }
    }

    public function concessionaireFrom()
    {
        $idCiudad=(int)$_POST['id'];
        $concessionaires=ConcessionaireRepository::getInstance()->listFrom($idCiudad);
        echo ($concessionaires);

    }
}