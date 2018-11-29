<?php

class RoomsList extends TwigView {
    
    public function show($rol, $rooms, $fechaDesde, $fechaHasta) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("roomsList.html.twig");

    	$template->display(array('rol' => $rol, 'rooms' => $rooms, 'fechaDesde' => $fechaDesde, 'fechaHasta' => $fechaHasta)); 
                
    }
    
}