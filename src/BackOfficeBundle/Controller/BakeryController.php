<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 06/02/2018
 * Time: 9:05 PM
 */

namespace BackOfficeBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BakeryController extends Controller
{
    public function layoutAction()
    {
        return $this->render('BackOfficeBundle:Bakery:base.html.twig');
    }

    public function profileAction()
    {
        return $this->render('BackOfficeBundle:Bakery:profile.html.twig');
    }


    public function dataAction()
    {
        return $this->render('BackOfficeBundle:Bakery:data.html.twig');
    }

    public function simpleAction()
    {
        return $this->render('BackOfficeBundle:Bakery:simple.html.twig');
    }

    public function chartAction()
    {
        return $this->render('BackOfficeBundle:Bakery:chart.html.twig');
    }
}