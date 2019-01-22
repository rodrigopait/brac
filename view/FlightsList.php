<?php

class FlightsList extends TwigView {

    public function show($rol, $flights) {
        #var_dump($flights);die;
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
		$twig->getExtension('Twig_Extension_Core')->setNumberFormat(0, ',', '.');
    	$template = $twig->loadTemplate("flightsList.html.twig");
    	$template->display(array('rol' => $rol,'flights' =>json_decode($flights)));

    }

}
