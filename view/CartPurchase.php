<?php

class CartPurchase extends TwigView {
    
    public function show($rol) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("cartPurchase.html.twig");

    	$template->display(array('rol' => $rol)); 
                
    }
    
}