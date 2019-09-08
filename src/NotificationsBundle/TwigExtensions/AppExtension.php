<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 24/02/2018
 * Time: 3:40 PM
 */

namespace NotificationsBundle\TwigExtensions;

use NotificationsBundle\Entity\Notification;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('notRead', array($this, 'notReadFilter')),
        );
    }


    /**
     * @param $notifications
     * @return array
     */
    public function notReadFilter($notifications)
    {
        $res = array();
        foreach ($notifications as $notif){

            /**
             * @var Notification
             */
            if(!$notif->isRead()){
                array_push($res, $notif);
            }
        }

        usort($res, function($a,$b){
            return $a->getDate()<$b->getDate();
        });

        return $res;
    }

    public function getName()
    {
        return 'notRead';
    }
}