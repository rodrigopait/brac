<?php

class RoomsList extends TwigView {

    public function show($rol, $rooms, $fechaDesde, $fechaHasta, $rooms_carrito=null) {

    $templateDir="./templates";
		$templateDirCompi="./templates-c";
		$loader = new Twig_Loader_Filesystem($templateDir);
		//$twig = new Twig_Environment($loader);
		$twig = new Twig_Environment($loader, ['debug' => true]);
        $twig->addExtension(new Twig_Extension_Debug());
    	$template = $twig->loadTemplate("roomsList.html.twig");

    	$template->display(array('rol' => $rol, 'rooms' => $rooms, 'fechaDesde' => $fechaDesde, 'fechaHasta' => $fechaHasta, 'rooms_carrito' => $rooms_carrito));

    }

}
