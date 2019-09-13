<?php
/**
 * Created by PhpStorm.
 * User: Emir
 * Date: 11/09/2019
 * Time: 01:23
 */

namespace ProductManagementBundle\Controller;
use ProductManagementBundle\Entity\Marque;
use ProductManagementBundle\Form\MarqueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MarqueController extends Controller
{
    public function getAllAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $marques = $em->getRepository('ProductManagementBundle:Marque')->findAll();
        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));

        $marque = new Marque();

        $form = $this->createForm(MarqueType::class, $marque, array('isEdit'=>false));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($marque);
            $em->flush();
            return $this->redirectToRoute('all_marque_admin');
        }
        $categories = $em->getRepository('ProductManagementBundle:Category')->findAll();
        $subcategories = $em->getRepository('ProductManagementBundle:SubCategory')->findAll();
        if($categories==null){
            $showsubcategory="false";
            $showmarque="false";
        }
        elseif ($subcategories==null){
            $showmarque="false";
            $showsubcategory="true";

        }
        else{
            $showmarque="true";
            $showsubcategory="true";
        }
        return $this->render('ProductManagementBundle:Marque:marques.html.twig', array('notifications'=>$notifications,'marques'=>$marques,
            'showsubcategory'=>$showsubcategory,'showmarque'=>$showmarque,'form'=>$form->createView()));
    }
    public function editAction(Request $request){
        $id = $request->get('marque');
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));
        $marque = $em->getRepository('ProductManagementBundle:Marque')->find($id);
        $form = $this->createForm(MarqueType::class, $marque, array('isEdit'=>true));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($marque);
            $em->flush();
            return $this->redirectToRoute('all_marque_admin');
        }
        $categories = $em->getRepository('ProductManagementBundle:Category')->findAll();
        $subcategories = $em->getRepository('ProductManagementBundle:SubCategory')->findAll();
        if($categories==null){
            $showsubcategory="false";
            $showmarque="false";
        }
        elseif ($subcategories==null){
            $showmarque="false";
            $showsubcategory="true";

        }
        else{
            $showmarque="true";
            $showsubcategory="true";
        }
        return $this->render('ProductManagementBundle:Marque:editMarque.html.twig', array('notifications'=>$notifications,
            'showsubcategory'=>$showsubcategory,'showmarque'=>$showmarque,'form'=>$form->createView()));
    }
    public function deleteAction(Request $request){
        $id = $request->get('marque');
        $em = $this->getDoctrine()->getManager();
        $marque = $em->getRepository('ProductManagementBundle:Marque')->find($id);
        $em->remove($marque);
        $em->flush();
        return $this->redirectToRoute('all_marque_admin');
    }
}