<?php

class Clase {
    
    private $id;
    private $descripcion;
    
    public function __construct($id,$descripcion) {
        $this->id = $id;
        $this->descripcion = $descripcion;
        
    }

    public function add_clase($descrip) {

        $this->descripcion = $descrip;

    }

    public function getId()
    {
        return $this->id;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }


}