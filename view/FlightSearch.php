<?php

class FlightSearch extends TwigView {

    public function show($clase,$paises) {
      #var_dump($paises);die;
      $templateDir="./templates";
		  $templateDirCompi="./templates-c";
		  $loader = new Twig_Loader_Filesystem($templateDir);
		  $twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("flightSearch.html.twig");

    	$template->display(array('clases' => $clase, 'countries' => $paises));


    }

}
