<?php

namespace ProductManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        // FOR TESTING ONLY


        //$em = $this->getDoctrine()->getManager();


        //$bakery = $em->getRepository('BakeryManagementBundle:Bakery')->find(1);
        //$products = $em->getRepository('ProductManagementBundle:Product')->getTopSellsByBakery($bakery);
        //$brand = $em->getRepository('BakeryManagementBundle:Enseigne')->find(1);
        //$products = $em->getRepository('ProductManagementBundle:Product')->getTopSells();
        $products = $em->getRepository('ProductManagementBundle:Product')->getLatestProducts();

        return $this->render('ProductManagementBundle:Default:index.html.twig', array('prods'=>$products));

        //return $this->render('ProductManagementBundle:Default:index.html.twig');
    }
}
