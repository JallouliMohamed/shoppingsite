<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 06/02/2018
 * Time: 8:15 PM
 */

namespace BackOfficeBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function layoutAction()
    {
        return $this->render('BackOfficeBundle:Admin:base.html.twig');
    }

    public function profileAction()
    {
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));
        return $this->render('BackOfficeBundle:Admin:profile.html.twig', array('notifications'=>$notifications));
    }


    public function dataAction()
    {
        return $this->render('BackOfficeBundle:Admin:data.html.twig');
    }

    public function simpleAction()
    {
        return $this->render('BackOfficeBundle:Admin:simple.html.twig');
    }

    public function chartAction()
    {
        return $this->render('BackOfficeBundle:Admin:chart.html.twig');
    }

    /*
    public function mailboxAction()
    {
        return $this->render('BackOfficeBundle:Admin:mailbox.html.twig');
    }

    public function composeAction()
    {
        return $this->render('BackOfficeBundle:Admin:compose.html.twig');
    }

    public function readMailAction()
    {
        return $this->render('BackOfficeBundle:Admin:readMail.html.twig');
    }
    */
}