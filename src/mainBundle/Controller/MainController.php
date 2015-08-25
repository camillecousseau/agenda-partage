<?php

namespace mainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('mainBundle:Main:index.html.twig');
    }
}
