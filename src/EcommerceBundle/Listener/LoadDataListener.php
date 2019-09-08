<?php
/**
 * Created by PhpStorm.
 * User: berrahal
 * Date: 2/23/18
 * Time: 1:59 PM
 */

namespace EcommerceBundle\Listener;
use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use AncaRebeca\FullCalendarBundle\Model\Event;
use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use EcommerceBundle\Entity\Planning;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\NotNull;

class LoadDataListener
{
    /**
     * @var EntityManager
     */
    private $em;
    private $tokenStorage;
    public function __construct(EntityManager $em,TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadData(CalendarEvent $calendarEvent)
    {

        // You can retrieve information from the event dispatcher (eg, You may want which day was selected in the calendar):
        // $startDate = $calendarEvent->getStart();
        // $endDate = $calendarEvent->getEnd();
        // $filters = $calendarEvent->getFilters();
        // You may want do a custom query to populate the events
        // $currentEvents = $repository->findByStartDate($startDate);
        $colorplanning='#008000';
        $colororder='#0000CD';
        $repository = $this->em->getRepository('EcommerceBundle:Planning');
        $plannings = $repository->findAll();


        // You may want to add an Event into the Calendar view.
        /** @var Planning $planning */
        foreach ($plannings as $planning) {
          if ($planning->getLineorder()==null)
            $calendarEvent->addEvent(new Event($planning->getUtilisateur()->getUsername().' Disponible', $planning->getDateStart(),$planning->getDateEnd(),$colorplanning));
          else
              $calendarEvent->addEvent(new Event($planning->getUtilisateur()->getUsername().' Affecté', $planning->getDateStart(),$planning->getDateEnd(),$colororder));

        }

    }


}