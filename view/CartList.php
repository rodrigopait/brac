<?php

class CartList extends TwigView {
    
    public function show($rol, $cart) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader, ['debug' => true]);
        $twig->addExtension(new Twig_Extension_Debug());
		$twig->getExtension('Twig_Extension_Core')->setNumberFormat(0, ',', '.');
    	$template = $twig->loadTemplate("cartList.html.twig");

    	$template->display(array('rol' => $rol, 'carrito' => $cart)); 
    }
    
}