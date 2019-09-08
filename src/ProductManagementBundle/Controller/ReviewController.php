<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 13/02/2018
 * Time: 7:32 PM
 */

namespace ProductManagementBundle\Controller;


use ProductManagementBundle\Entity\Product;
use ProductManagementBundle\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReviewController extends Controller
{
    public function getReviewsAction(Request $request){

        $product = $request->get('product');
        $em = $this->getDoctrine()->getManager();

        $reviews = $em->getRepository('ProductManagementBundle:Review')->findBy(array('product'=>$product));
        return $reviews;
    }

    public function removeReviewAction(Request $request){
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $Review = $em->find('ProductManagementBundle:Review', $id);

        $em->remove($Review);
        $em->flush();

        return $this->redirectToRoute('product_page', array('id'=>$Review->getProduct()->getId()));
    }

}