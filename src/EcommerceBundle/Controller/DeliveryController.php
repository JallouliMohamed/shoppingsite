<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\Planning;
use EcommerceBundle\Form\AffectationPlanningType;
use EcommerceBundle\Form\PlanningType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotNull;
use UsersBundle\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DeliveryController extends Controller
{



    public  function showPlanningAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $plannings = $em->getRepository('EcommerceBundle:Planning')->findBy(array('utilisateur' => $this->getUser()->getId()));
        // $categories = $em->getRepository('ProductManagementBundle:Category')->findAll();
        $planning = new Planning('Disponile',new \DateTime(),new \DateTime());
dump($plannings);
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);
        $utilisateur = $this->getUser();

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $planning->setUtilisateur($utilisateur);

            $em->persist($planning);
            $em->flush();
            return $this->redirectToRoute('delivery_show_planning');
        }



        return $this->render('@Ecommerce/showplanning.html.twig', array('plannings'=>$plannings,
        'form'=>$form->createView()));
    }

    public  function affectationplanningAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $lineorder = $em->getRepository('EcommerceBundle:LineOrder')->findOneBy(array('id' => $id));
        $utilisateurs = $em->getRepository('UsersBundle:Users')->findBy(array('zone' => $lineorder->getOrder()->getAdresse()->getVille()));

        $plannings = $em->getRepository('EcommerceBundle:Planning')->findBy(array('utilisateur' => $utilisateurs,
            'lineorder' => null));
        $planning = new Planning('Affectation',new \DateTime(),new \DateTime());
        $form = $this->createFormBuilder($planning)
            ->add('datestart',DateTimeType::class, array(
                'placeholder' => array(
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute',
                )
            ))

            ->add('utilisateur', EntityType::class, array(
                // looks for choices from this entity
                'class' => Users::class,
                'choice_label' => function ($utilisateurs) {
                     return $utilisateurs->getUsername();
                }
            ))

            ->add('sauvegarder', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $planning->setDateEnd($planning->getDateStart()->modify('+ 30 minutes'));
            $planning->setLineorder($lineorder);
            $em->persist($planning);
            $em->flush();
            return $this->redirectToRoute('bakeryalllineorders');
        }
        return $this->render('@Ecommerce/affectationplanning.html.twig', array('plannings'=>$plannings,
            'utilisateur'=>$utilisateurs,
            'lineorder'=>$lineorder,
            'form'=>$form->createView(),
            ));


    }

    public  function listAffectedOrdersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $plannings = $em->getRepository('EcommerceBundle:Planning')->findBy(array('utilisateur' => $this->getUser()->getId()));


        return $this->render('@Ecommerce/listaffectedorders.html.twig', array('plannings'=>$plannings));
    }

}
