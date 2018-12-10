<?php
class IndexUser extends TwigView {

    public function show($rol,$usuario) {

	  $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("indexUser.html.twig");
    	$rol = $_SESSION['rol'];
      
    	$template->display(array('rol' => $rol, 'usuario' => $usuario));
    }
}
?>
