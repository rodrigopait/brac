<?php

class UserPurchasesDetail extends TwigView {
    
    public function show($compras, $rol, $comprasDetalle) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("userPurchasesDetail.html.twig");
    	
    	$template->display(array('rol' => $rol, 'vuelos' => $comprasDetalle[0], 'habitaciones' => $comprasDetalle[1], 'autos' => $comprasDetalle[2], 'compras' => $compras)); 
                
    }
    
}