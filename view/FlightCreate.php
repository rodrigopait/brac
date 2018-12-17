<?php

class FlightCreate extends TwigView {
    
    public function show($rol,$airlines,$countries) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("flightCreate.html.twig");
        $template->display(array('rol' => $rol, 'airlines' => $airlines, 'countries' => $countries)); 
        
        
    }
    
}