<?php

class User {
    
    private $id;
    private $usuario;
    private $clave;
    private $nombre;
    private $apellido;
    private $email;
    private $rol;
    
    public function __construct($id, $usuario, $clave, $nombre, $apellido, $email, $rol) {

        $this->id = $id;
        $this->usuario = $usuario;
        $this->clave = $clave;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->rol = $rol;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getClave() {
        return $this->clave;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRol() {
        return $this->rol;
    }

}

?>