<?php

class UserRegistration extends TwigView {
    
    public function show() {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("userRegistration.html.twig");
    	$rol = $_SESSION['rol'];

    	$template->display(array('rol' => $rol)); 
                
    }
    
}