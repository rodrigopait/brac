<?php

class UserInformation extends TwigView {
    
    public function show($rol, $user) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("userInformation.html.twig");

    	$template->display(array('rol' => $rol, 'usuario' => $user)); 
                
    }
    
}