<?php

namespace UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UsersBundle\Entity\Adresses;
use Symfony\Component\HttpFoundation\Request;
use UsersBundle\Form\AddressesType;
use UsersBundle\Repository\AdressesRepository;

class AdressesController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    public  function listAddressAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $addresses = $em->getRepository('UsersBundle:Adresses')->findBy(array('utilisateur' => $this->getUser()->getId()));
       // $categories = $em->getRepository('ProductManagementBundle:Category')->findAll();
        $address = new Adresses();
//dump($addresses);
        $form = $this->createForm(AddressesType::class, $address);
        $form->handleRequest($request);
        $utilisateur = $this->getUser();

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $address->setUtilisateur($utilisateur);

            $em->persist($address);
            $em->flush();
            return $this->redirectToRoute('useralladdresses');
        }

        return $this->render('@Users/listAdresses.html.twig', array('addresses'=>$addresses,
            'form'=>$form->createView()));
    }


    public function deleteAction(Request $request){
        $id = $request->get('address');
        $em = $this->getDoctrine()->getManager();
        $address = $em->getRepository('UsersBundle:Adresses')->find($id);
        if($address->getUtilisateur()!=$this->getUser())
        {
            return $this->redirectToRoute('useralladdresses');
        }

        $em->remove($address);
        $em->flush();
        return $this->redirectToRoute('useralladdresses');
    }

    public function editAction(Request $request){
        $id = $request->get('address');
        $em = $this->getDoctrine()->getManager();
        $address = $em->getRepository('UsersBundle:Adresses')->find($id);
        $form = $this->createForm(AddressesType::class, $address);
        $form->handleRequest($request);
        if($address->getUtilisateur()!=$this->getUser())
        {
            return $this->redirectToRoute('useralladdresses');
        }

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();
            return $this->redirectToRoute('useralladdresses');
        }

        return $this->render('@Users/editaddress.html.twig', array(
            'form'=>$form->createView()));
    }
}
