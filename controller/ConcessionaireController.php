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
            $view = new ConcessionaireCreate();
            $view->show($rol);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }

    public function concessionaireAdd($nombre,$ciudad,$pais){
        try{
            ConcessionaireRepository::getInstance()->concessionaireAdd($nombre,$ciudad,$pais);
            $concessionaires = ConcessionaireRepository::getInstance()->listAll();
            $view = new ConcessionairesList();
            $rol = $_SESSION['rol'];
            $view->show($rol, $concessionaires);
        }
        catch (PDOException $e){
            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
            $view = new Error_display();
            $view->show($error);
        }
    }
}