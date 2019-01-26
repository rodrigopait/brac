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
        $pasajerosDirectos=$_SESSION['carrito']['directos']['datos'];
        $pasajerosEscala=$_SESSION['carrito']['escalas']['datos'];

    	$template->display(array('rol' => $rol, 'carrito' => $cart, 'pasajerosEscala'=>$pasajerosEscala, 'pasajerosDirectos'=>$pasajerosDirectos)); 
    }
    
}