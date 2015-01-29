<?php

namespace Sportacus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('SportacusCoreBundle:Home:index.html.twig', array());
    }
}
