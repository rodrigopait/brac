<?php

class Home extends TwigView {
<<<<<<< HEAD

    public function show() {

=======
    
    public function show($message=null) {
        
>>>>>>> d9fe05e83f97b2e899fb8181df563807f335ba28
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("home.html.twig");
    	$rol = $_SESSION['rol'];
<<<<<<< HEAD
    	
    	$template->display(array('rol' => $rol));


=======
    	$template->display(array('rol' => $rol, 'mensajeError' => $message)); 
        
        
>>>>>>> d9fe05e83f97b2e899fb8181df563807f335ba28
    }

}
