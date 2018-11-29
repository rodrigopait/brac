<?php

class CarsList extends TwigView {
    
    public function show($rol, $cars, $fechaDesde, $fechaHasta) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("carsList.html.twig");

    	$template->display(array('rol' => $rol, 'cars' => $cars, 'fechaDesde' => $fechaDesde, 'fechaHasta' => $fechaHasta)); 
                
    }
    
}