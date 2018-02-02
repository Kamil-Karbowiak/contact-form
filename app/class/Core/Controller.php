<?php
namespace ContactForm\Core;

abstract class Controller
{
    public function view($view, $data = [])
    {
		$loader = new \Twig_Loader_Filesystem(VIEWS_DIR);
		$twig = new \Twig_Environment($loader);
		echo $twig->render($view, $data);
		die();
	}
}