<?php

class createHotel extends TwigView {
    
    public function show() {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("createHotel.html.twig");

        $template->display(); 
        
        
    }
    
}