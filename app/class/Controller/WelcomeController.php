<?php
namespace ContactForm\Controller;

use ContactForm\Core\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        $this->view('welcome/index.html.twig');
    }
}