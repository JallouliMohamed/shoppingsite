<?php

namespace BakeryManagementBundle\Controller;
use BakeryManagementBundle\Repository;

use BakeryManagementBundle\Entity\Bakery;
use BakeryManagementBundle\Form\BakeryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class BakeryController extends Controller
{
    public function addAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $enseignes=$em->getRepository("BakeryManagementBundle:Enseigne")->findOneByuser($user);

        $bakery = new Bakery();
        $form = $this->createForm(BakeryType::class, $bakery);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $bakery->setEnseigne($enseignes);
            $bakery->getUser()->addRole('ROLE_BAKERY');
            $em->persist($bakery);
            $em->flush();
            // ... persist the $product variable or any other work

            return $this->redirectToRoute("back_office_homepage_brand");
        }
        return $this->render('BakeryManagementBundle:Bakery:add.html.twig',
            array(
                "form" => $form->createView()
            ));
    }
    public function listAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
       $enseignes = $em->getRepository('BakeryManagementBundle:Enseigne')->findBy(array('user' => $user));
        $patisseries = $em->getRepository('BakeryManagementBundle:Bakery')->findByenseigne($enseignes);
        $patisseries  = $this->get('Knp_paginator')->paginate($patisseries,$request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/);

        return $this->render('BakeryManagementBundle:Bakery:list.html.twig',
            array("patisseries" => $patisseries));

    }
    public function updateAction(Request $req)
    {
        $id=$req->get('id');
        $em=$this->getDoctrine()->getManager();
        $patisseries=$em->getRepository("BakeryManagementBundle:Bakery")->find($id); //ici $modele est un objet et non pas un tab
        $form=$this->createForm(BakeryType::class,$patisseries);
        $form->handleRequest($req); //controler si le 1ere visite au sys ou 2eme
        if($form->isValid()){ // acceder au entity
            $patisseries->getUser()->addRole('ROLE_BAKERY');

            $em->persist($patisseries); //appartient au getmanager
            $em->flush();
            return $this->redirectToRoute("brand_list");
        }
        return $this->render('BakeryManagementBundle:Bakery:update.html.twig',array('form'=>$form->createView()));

    }
    public function deleteAction(Request $req){
        $id=$req->get('id');
        $em=$this->getDoctrine()->getManager();
        $patisserie=$em->getRepository("BakeryManagementBundle:Bakery")->find($id);
        $em->remove($patisserie);
        $em->flush(); //exécuter le commande remove
        return $this->redirectToRoute("brand_list"); //render exige un tab de parametre or que ici on ne va pas passer le paramétre

    }
    public function listPropositionsAction($id)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $enseignes = $em->getRepository('BakeryManagementBundle:Enseigne')->find($id);
        $latLng = $em->getRepository("BakeryManagementBundle:Bakery")->findaddress($enseignes);

        $response = $serializer->serialize($latLng, 'json');
        return $this->render('BakeryManagementBundle:Bakery:ListProposals.html.twig', array("locations" => $response));

    }
    public function listPropositions2Action()
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $enseignes = $em->getRepository('BakeryManagementBundle:Enseigne')->findBy(array('user' => $user));
        $latLng = $em->getRepository("BakeryManagementBundle:Bakery")->findaddress($enseignes);

        $response = $serializer->serialize($latLng, 'json');
        return $this->render('BakeryManagementBundle:Bakery:ListProposals2.html.twig', array("locations" => $response));

    }
}
