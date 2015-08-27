<?php

namespace mainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MainController extends Controller
{
	/**
	 * @Route("/", name="main_homepage")
	 * @Template()
	 */
	
    public function indexAction()
    {
        /* return $this->render('mainBundle:Main:index.html.twig'); */
        return array();
    }
}
