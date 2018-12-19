<?php

class CarCreate extends TwigView
{

    public function show($rol,$countries,$brands,$concessionaries)
    {

        $templateDir = "./templates";
        $templateDirCompi = "./templates-c";
        $loader = new Twig_Loader_Filesystem($templateDir);
        $twig = new Twig_Environment($loader);
        $template = $twig->loadTemplate("carCreate.html.twig");
        $template->display(array('rol' => $rol, 'countries' => $countries, 'brands' =>$brands, 'concessionaires' => $concessionaries));


    }

}