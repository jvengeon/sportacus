<?php

namespace Sportacus\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SportacusCoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
