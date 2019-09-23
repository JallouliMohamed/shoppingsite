<?php

namespace UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /*public function indexAction()
    {
        return $this->render('UsersBundle:Default:index.html.twig');
    }*/

    public function indexAction()
    {
        return $this->render('::base.html.twig');
    }
    public function userProfileAction(){
        $users = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $product=$em->getRepository('ProductManagementBundle:Product')->findByuser($users);
        return $this->render('@Users/profile.html.twig', array(
            'users' => $users,"products"=>$product));
    }
    public function userProductAction(){
        $users = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $product=$em->getRepository('ProductManagementBundle:Product')->findByuser($users);
        return new JsonResponse($product);
}

}
