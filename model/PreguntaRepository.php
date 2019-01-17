<?php

class PreguntaRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /*public function listAll()
    {
        $query = $this->queryList("SELECT * FROM pais ORDER BY nombre", array());
        foreach ($query[0] as $row) {
            $country = new Country( $row['id'], $row['nombre']);
            $countries[]=$country;
        }
        return $countries;
    }*/

    private function __construct() {
	}
    public function listAll()
    {
    	$query = $this->queryList("SELECT * FROM preguntas", array());
        foreach ($query[0] as $row) {
            $pregunta = new Pregunta( $row['id_pregunta'], $row['pregunta']);
            $preguntas[]=$pregunta;
        }
        return $preguntas;
    }

    /*public function getPregunta($idPregunta)
    {
        $query = PreguntaRepository::getInstance()->queryList("select * FROM pregunta where id = ?", array($idPregunta));

        $preguntas = [];
        foreach ($query[0] as $row) {
            #var_dump($row);
            $pregunta = new Pregunta($row['id_pregunta'], $row['descripcion']);
            $preguntas[] = $clase;
        }
        $query = null;
        return $preguntas;
    }*/

}
  