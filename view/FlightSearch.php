<?php

class FlightSearch extends TwigView {
    
    public function show($clase) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("flightSearch.html.twig");
    	
    	$template->display(array('clases' => $clase)); 
        
        
    }
    
}