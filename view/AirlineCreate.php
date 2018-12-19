<?php

class AirlineCreate extends TwigView {
    
    public function show($rol) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("airlineCreate.html.twig");

    	$template->display(array('rol' => $rol)); 
        
        
    }
    
}