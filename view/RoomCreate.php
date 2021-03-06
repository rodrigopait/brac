<?php

class RoomCreate extends TwigView{

    public function show ($rol,$countries,$message = null){
        $templateDir = "./templates";
        $templateDirCompi = "./templates-c";
        $loader = new Twig_Loader_Filesystem($templateDir);
        $twig = new Twig_Environment($loader);
        $template = $twig->loadTemplate("roomCreate.html.twig");
        $template->display(array('rol' => $rol, 'countries' => $countries, 'message' => $message));
    }
}