<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 19/02/2018
 * Time: 8:29 PM
 */

namespace NotificationsBundle\Controller;


use NotificationsBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function addNotificationAction(Request $request){
        $id = $request->get('user_id');
        $msg = $request->get('msg');
        $link = $request->get('link');

        $em = $this->getDoctrine()->getManager();
        $user = $em->find('UsersBundle:users', $id);

        $notification = new Notification($msg, $link, $user);
        $em->persist($notification);
        $em->flush();

        return new Response("Notification sent");
    }

    public function markNotificationAction(Request $request){
        $id = $request->get('notif_id');
        $em = $this->getDoctrine()->getManager();
        $notif = $em->find('NotificationsBundle:Notification', $id);
        $notif->setIsRead(true);
        $em->persist($notif);
        $em->flush();

        return $this->redirect($notif->getLink());
    }
}