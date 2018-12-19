<?php

class Configuration{
    private $id;
    private $gap_max;
    private $descuento_escala;
    private $precio_puntos;
    private $precio_peso;
    private $porcentaje_devolucion;
    private $intentos_sesion;
    private $precio_ejecutiva;
    private $precio_primera;
    
    public function __construct($id, $gap_max,$descuento_escala,$precio_puntos,$precio_peso,$porcentaje_devolucion,$intentos_sesion,$precio_ejecutiva,$precio_primera) {

        $this->id = (int)$id;
        $this->gap_max=(int)$gap_max;
		$this->descuento_escala=(int)$descuento_escala;
		$this->precio_puntos=(int)$precio_puntos;
		$this->precio_peso=(int)$precio_peso;
		$this->porcentaje_devolucion=(int)$porcentaje_devolucion;;
		$this->intentos_sesion=(int)$intentos_sesion;
		$this->precio_ejecutiva=(int)$precio_ejecutiva;
		$this->precio_primera=(int)$precio_primera;

    }

    public function getId() {
        return $this->id;
    }

    public function getGapMax() {
        return $this->gap_max;
    }
    public function getDescuentoEscalas() {
        return $this->descuento_escala;
    }
    public function getPrecioPorPuntos() {
        return $this->precio_puntos;
    }
    public function getPrecioPeso() {
        return $this->precio_peso;
    }
    public function getPorcentajeDevolucion() {
        return $this->porcentaje_devolucion;
    }

    public function getIntentosSesion() {
        return $this->intentos_sesion;
    }
    public function getPrecioEjecutiva() {
        return $this->precio_ejecutiva;
    }
    public function getPrecioPrimera() {
        return $this->precio_primera;
    }


}
