<?php

class Purchase {
    
    private $id;
    private $fecha;
    private $total;
    private $usuarioId;
    
    public function __construct($id, $fecha, $total, $usuarioId) {
        
        $this->id = $id;
        $this->fecha = $fecha;
        $this->total = $total;
        $this->usuarioId = $usuarioId;
    }

    public function getId() {
        return $this->id;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getUsuarioId () {
        return $usuarioId;
    }
}

?>