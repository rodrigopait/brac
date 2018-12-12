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

    public function concessionaireCreate($nombre,$ciudad,$pais,$reputacion_id){
        try{
            ConcessionaryRepository::getInstance()->concessionaireAdd($nombre,$ciudad,$pais,$reputacion_id);
            $concessionaires = ConcessionaryRepository::getInstance()->listAll();
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