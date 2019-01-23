<?php

class FlightsList extends TwigView {

    public function show($rol, $flights,$session=null) {
        #var_dump($flights);die;
        $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		$twig = new Twig_Environment($loader, ['debug' => true]);
        $twig->addExtension(new Twig_Extension_Debug());
		$twig->getExtension('Twig_Extension_Core')->setNumberFormat(0, ',', '.');
    	$template = $twig->loadTemplate("flightsList.html.twig");
    	$template->display(array('rol' => $rol,'flights' =>json_decode($flights),'carrito'=>$session));

    }

}
