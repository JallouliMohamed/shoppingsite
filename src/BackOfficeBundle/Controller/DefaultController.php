<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BackOfficeBundle::layout.html.twig');
    }

    public function layoutAction()
    {
        return $this->render('BackOfficeBundle::layout.html.twig');
    }

    public function profileAction()
    {
        return $this->render('BackOfficeBundle:Template:profile.html.twig');
    }

    public function loginAction()
    {
        return $this->render('BackOfficeBundle:Template:login.html.twig');
    }

    public function dataAction()
    {
        return $this->render('BackOfficeBundle:Template:data.html.twig');
    }

    public function simpleAction()
    {
        return $this->render('BackOfficeBundle:Template:simple.html.twig');
    }

    public function chartAction()
    {
        return $this->render('BackOfficeBundle:Template:chart.html.twig');
    }

    public function mailboxAction()
    {
        return $this->render('BackOfficeBundle:Template:mailbox.html.twig');
    }

    public function composeAction()
    {
        return $this->render('BackOfficeBundle:Template:compose.html.twig');
    }

    public function readMailAction()
    {
        return $this->render('BackOfficeBundle:Template:readMail.html.twig');
    }
}
