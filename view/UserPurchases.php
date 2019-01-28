<?php

class UserPurchases extends TwigView {
    
    public function show($rol, $username, $vigentes, $cerradas=null) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
		$twig->getExtension('Twig_Extension_Core')->setNumberFormat(0, ',', '.');
    	$template = $twig->loadTemplate("userPurchases.html.twig");

    	$template->display(array('rol' => $rol,'usuario' => $username, 'vigentes'=> $vigentes, 'cerradas'=> $cerradas)); 
                
    }
    
}