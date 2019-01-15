<?php



class Pregunta {

    private $id_pregunta;
    private $pregunta;
    
    public function __construct($id_pregunta, $pregunta) {

        $this->id_pregunta = $id_pregunta;
        $this->pregunta = utf8_encode($pregunta);

    }

    public function getIdPregunta() {
        return $this->id_pregunta;
    }

    public function getPregunta() {
        return $this->pregunta;
    }
}
