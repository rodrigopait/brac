<?php

class UserPurchasesDetail extends TwigView {
    
    public function show($compras, $rol, $comprasDetalle, $canceladas, $config,$valor=null) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader, ['debug' => true]);
		$twig->addExtension(new Twig_Extension_Debug());
		$twig->getExtension('Twig_Extension_Core')->setNumberFormat(0, ',', '.');
    	$template = $twig->loadTemplate("userPurchasesDetail.html.twig");
    	
    	$template->display(array('rol' => $rol, 'carrito' => $comprasDetalle,'canceladas'=>$canceladas, 'compras' => $compras, 'config'=>$config, 'valor'=>$valor)); 
                
    }
    
}