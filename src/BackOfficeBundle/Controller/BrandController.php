<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 06/02/2018
 * Time: 9:15 PM
 */

namespace BackOfficeBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BrandController extends Controller
{
    public function layoutAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $enseignes=$em->getRepository("BakeryManagementBundle:Enseigne")->findByuser($user);

        return $this->render('BackOfficeBundle:Brand:base.html.twig',array('img'=>$enseignes));
    }

    public function profileAction()
    {
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));
        return $this->render('BackOfficeBundle:Brand:profile.html.twig', array('notifications'=>$notifications));
    }


    public function dataAction()
    {
        return $this->render('BackOfficeBundle:Brand:data.html.twig');
    }

    public function simpleAction()
    {
        return $this->render('BackOfficeBundle:Brand:simple.html.twig');
    }

    public function chartAction()
    {
        return $this->render('BackOfficeBundle:Brand:chart.html.twig');
    }
    public function chart2Action()
    {
        return $this->render('BakeryManagementBundle:Graphe:chart2.html.twig');
    }
}