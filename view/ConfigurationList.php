<?php

class ConfigurationList extends TwigView {
    
    public function show($rol, $config) {
        
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("configuration.html.twig");

    	$template->display(array('rol' => $rol, 'config'=>$config)); 
        
        
    }
    
}