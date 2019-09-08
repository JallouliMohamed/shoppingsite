<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 11/02/2018
 * Time: 7:52 PM
 */

namespace ProductManagementBundle\Controller;


use ProductManagementBundle\Entity\Category;
use ProductManagementBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function getAllAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ProductManagementBundle:Category')->findAll();
        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category, array('isEdit'=>false));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('all_categories_admin');
        }

        return $this->render('ProductManagementBundle:Category:categories.html.twig',
            array('categories'=>$categories, 'notifications'=>$notifications,
            'form'=>$form->createView()));
    }

    public function editAction(Request $request){
        $id = $request->get('category');
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('ProductManagementBundle:Category')->find($id);
        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));
        $form = $this->createForm(CategoryType::class, $category, array('isEdit'=>true));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('all_categories_admin');
        }

        return $this->render('ProductManagementBundle:Category:editCategory.html.twig', array( 'notifications'=>$notifications,
            'form'=>$form->createView()));
    }

    public function deleteAction(Request $request){
        $id = $request->get('category');
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('ProductManagementBundle:Category')->find($id);
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('all_categories_admin');
    }

    public function showAllCategoriesAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ProductManagementBundle:Category')->findAll();
        $subcategories = $em->getRepository('ProductManagementBundle:SubCategory')->findAll();
        return $this->render('ProductManagementBundle:Category:CategoriesFront.html.twig',
            array('categories'=>$categories, 'subcategories'=>$subcategories));
    }

    /*public function showCategoryAction(Request $request){
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('ProductManagementBundle:Category')->find($id);
        return $this->render('ProductManagementBundle:Category:categories.html.twig', array('category'=>$category));
    }*/
}