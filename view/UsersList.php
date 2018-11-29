<?php

class UsersList extends TwigView {
    
    public function show($rol, $users) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("usersList.html.twig");

    	$template->display(array('rol' => $rol, 'usuarios' => $users)); 
                
    }
    
}