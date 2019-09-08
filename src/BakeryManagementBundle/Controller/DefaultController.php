<?php

namespace BakeryManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BakeryManagementBundle:Default:index.html.twig');
    }
}
