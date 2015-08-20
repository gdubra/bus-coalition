<?php

namespace BusCoalition\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BusCoalitionWebBundle:Default:index.html.twig');
    }
}
