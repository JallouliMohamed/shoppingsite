<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Form\AdressesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use UsersBundle\Entity\Adresses;





class PanierController extends Controller
{

    public function menuAction(Request $request)
    {

        $session = $request->getSession();
        if (!$session->has('panier'))
            $produits = 0;
        else
            $produits = count($session->get('panier'));

        if (!$session->has('panier')) $session->set('panier', array());

        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ProductManagementBundle:Product')->findArray(array_keys($session->get('panier')));
        //die($produits);

        return $this->render('@Ecommerce/menupanier.html.twig', array('produits' => $produits,
            'panier' => $session->get('panier')));
    }


    public function ajouterAction($id, Request $request)
    {

         $session = $request->getSession();

         if (!$session->has('panier')) $session->set('panier',array());
         $panier = $session->get('panier', array());

         if (array_key_exists($id, $panier)) {
             if ($request->query->get('qte') != null) $panier[$id] = $request->query->get('qte');
             {
                 $session->set('panier',$panier);
                 $this->get('session')->getFlashBag()->add('success','Quantité modifié avec succès');
             }
         } else {
             if ($request->query->get('qte') != null)
                 $panier[$id] = $request->query->get('qte');
             else
                 $panier[$id] = 1;

             $this->get('session')->getFlashBag()->add('success','Article ajouté avec succès');
         }

         $session->set('panier',$panier);


         return $this->redirect($this->generateUrl('panier'));

    }

    public function livraisonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $this->getUser();
        //var_dump($utilisateur);
        $entity = new Adresses();
        $form = $this->createForm(AdressesType::class,$entity);


        $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity->setUtilisateur($utilisateur);
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('livraison'));
            }


        return $this->render('EcommerceBundle::livraison.html.twig', array('utilisateur' => $utilisateur,
            'form' => $form->createView()));
    }

    public function supprimerAction($id, Request $request)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier))
        {
            unset($panier[$id]);
            $session->set('panier',$panier);
            $this->get('session')->getFlashBag()->add('success','Article supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('panier'));
    }




    public function panierAction(Request $request)
    {
        $session = $request->getSession();
       // $session->clear();
        $session->remove('commande');
        if (!$session->has('panier')) $session->set('panier', array());

        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ProductManagementBundle:Product')->findArray(array_keys($session->get('panier')));
        //die($produits);



        return $this->render('EcommerceBundle::panier.html.twig', array('produits' => $produits,
            'panier' => $session->get('panier')));
    }




    public function validationAction(Request $request)
    {
        if ($request->getMethod() == 'POST')
            $this->setLivraisonOnSession($request);

        $em = $this->getDoctrine()->getManager();
        $prepareCommande = $this->forward('EcommerceBundle:Order:prepareCommande');
        $commande = $em->getRepository('EcommerceBundle:Orders')->find($prepareCommande->getContent());
        return $this->render('@Ecommerce/validationpanier.html.twig', array('commande' => $commande));
    }

    public function adresseSuppressionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UsersBundle:Adresses')->find($id);

        if ($this->getUser() != $entity->getUtilisateur() || !$entity)
            return $this->redirect ($this->generateUrl ('livraison'));

        $em->remove($entity);
        $em->flush();

        return $this->redirect ($this->generateUrl ('livraison'));
    }

    public function setLivraisonOnSession(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('adresse')) $session->set('adresse',array());
        $adresse = $session->get('adresse');

        if ($request->request->get('livraison') != null && $request->get('facturation') != null)
        {
            $adresse['livraison'] = $request->get('livraison');
            $adresse['facturation'] = $request->get('facturation');
        } else {
            return $this->redirect($this->generateUrl('validation'));
        }

        $session->set('adresse',$adresse);
        return $this->redirect($this->generateUrl('validation'));
    }





}
