<?php

class FlightsList extends TwigView {
    
    public function show($rol, $flights) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("flightsList.html.twig");

    	$template->display(array('rol' => $rol, 'flights' => $flights)); 
                
    }
    
}