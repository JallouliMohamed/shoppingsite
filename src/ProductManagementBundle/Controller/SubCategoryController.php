<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 12/02/2018
 * Time: 12:25 PM
 */

namespace ProductManagementBundle\Controller;


use ProductManagementBundle\Entity\SubCategory;
use ProductManagementBundle\Form\SubCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SubCategoryController extends Controller
{
    public function getAllAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $subcategories = $em->getRepository('ProductManagementBundle:SubCategory')->findAll();
        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));
        $subcategory = new SubCategory();

        $form = $this->createForm(SubCategoryType::class, $subcategory, array('isEdit'=>false));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($subcategory);
            $em->flush();
            return $this->redirectToRoute('all_subcategories_admin');
        }

        return $this->render('ProductManagementBundle:SubCategory:SubCategories.html.twig', array('notifications'=>$notifications,'subcategories'=>$subcategories,
            'form'=>$form->createView()));
    }

    public function editAction(Request $request){
        $id = $request->get('subcategory');
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));
        $subcategory = $em->getRepository('ProductManagementBundle:SubCategory')->find($id);
        $form = $this->createForm(SubCategoryType::class, $subcategory, array('isEdit'=>true));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($subcategory);
            $em->flush();
            return $this->redirectToRoute('all_subcategories_admin');
        }

        return $this->render('ProductManagementBundle:SubCategory:editSubCategory.html.twig', array('notifications'=>$notifications,
            'form'=>$form->createView()));
    }

    public function deleteAction(Request $request){
        $id = $request->get('subcategory');
        $em = $this->getDoctrine()->getManager();
        $subcategory = $em->getRepository('ProductManagementBundle:SubCategory')->find($id);
        $em->remove($subcategory);
        $em->flush();
        return $this->redirectToRoute('all_subcategories_admin');
    }
}