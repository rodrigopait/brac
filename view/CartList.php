<?php

class CartList extends TwigView {
    
    public function show($rol, $cart) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("cartList.html.twig");

    	$template->display(array('rol' => $rol, 'cart' => $cart)); 
                
    }
    
}