<?php

class UserPurchases extends TwigView {
    
    public function show($compras, $rol, $username) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("userPurchases.html.twig");

    	$template->display(array('rol' => $rol, 'compras' => $compras, 'usuario' => $username)); 
                
    }
    
}