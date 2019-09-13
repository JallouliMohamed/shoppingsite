<?php
/**
 * Created by PhpStorm.
 * User: Emir
 * Date: 12/09/2019
 * Time: 23:48
 */

namespace ProductManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GrapheController extends Controller
{
public function chartAction(){
    $em = $this->getDoctrine()->getManager();
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
    return $this->render('ProductManagementBundle:Chart:productchart.html.twig',array('showsubcategory'=>$showsubcategory,'showmarque'=>$showmarque));
}
}