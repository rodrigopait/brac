<?php
class UserRecovery extends TwigView {
    
    public function show($user = null) {
        
	    $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("userRecovery.html.twig");
    	
        $template->display(array('user' => $user));                
    }   
}
?>