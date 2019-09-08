<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontBundle:Default:index.html.twig');
        //return $this->render('::base.html.twig');
    }
    public function aboutAction()
    {
        return $this->render('FrontBundle:Default:about.html.twig');
    }
    public function productAction()
    {
        return $this->render('FrontBundle:Default:product-grid.html.twig');
    }
    public function cartAction()
    {
        return $this->render('FrontBundle:Default:cart.html.twig');
    }
    public function categoryAction()
    {
        return $this->render('FrontBundle:Default:category.html.twig');
    }
    public function companyAction()
    {
        return $this->render('FrontBundle:Default:company.html.twig');
    }
    public function eventAction()
    {
        return $this->render('FrontBundle:Default:event.html.twig');
    }
    public function contactAction()
    {
        return $this->render('FrontBundle:Default:contact.html.twig');
    }
}
