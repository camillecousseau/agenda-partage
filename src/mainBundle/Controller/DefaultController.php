<?php

namespace mainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('mainBundle:Default:index.html.twig', array('name' => $name));
    }
}
