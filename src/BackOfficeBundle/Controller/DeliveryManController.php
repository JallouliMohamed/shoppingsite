<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 06/02/2018
 * Time: 9:15 PM
 */

namespace BackOfficeBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DeliveryManController extends Controller
{
    public function layoutAction()
    {
        return $this->render('BackOfficeBundle:DeliveryMan:base.html.twig');
    }

    public function profileAction()
    {
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));
        return $this->render('BackOfficeBundle:DeliveryMan:profile.html.twig', array('notifications'=>$notifications));
    }


    public function dataAction()
    {
        return $this->render('BackOfficeBundle:DeliveryMan:data.html.twig');
    }

    public function simpleAction()
    {
        return $this->render('BackOfficeBundle:DeliveryMan:simple.html.twig');
    }

    public function chartAction()
    {
        return $this->render('BackOfficeBundle:DeliveryMan:chart.html.twig');
    }
}