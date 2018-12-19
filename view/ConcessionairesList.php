<?php

class ConcessionairesList extends TwigView {
    
    public function show($rol, $concessionaires) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("concessionairesList.html.twig");

    	$template->display(array('rol' => $rol, 'flights' => $concessionaires)); 
                
    }
    
}