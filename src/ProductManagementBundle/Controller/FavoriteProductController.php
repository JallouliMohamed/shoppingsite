<?php
/**
 * Created by PhpStorm.
 * User: Emir
 * Date: 17/09/2019
 * Time: 23:03
 */

namespace ProductManagementBundle\Controller;


use ProductManagementBundle\Entity\FavoriteProduct;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FavoriteProductController extends Controller
{
    public function addFavoriteAction(Request $request){

        $id = $request->get('product');
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ProductManagementBundle:Product')->find($id);

        $favorite = $em->getRepository('ProductManagementBundle:FavoriteProduct')
            ->findOneBy(array('product'=>$product, 'user'=>$this->getUser()));
        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $favorite = new FavoriteProduct($product,$usr);

        $em->persist($favorite);
        $em->flush();



        return $this->redirectToRoute('showProduct');
    }
    //showproducts.html wishlist
    public function getMyFavoritesAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $favorites = $em->getRepository('ProductManagementBundle:FavoriteProduct')
            ->findBy(array('user'=>$this->getUser()));

        return $favorites;
    }
    public function listFavoriteAction(Request $request){
        //$favs = $this->forward('ProductManagementBundle:Favorite:getMyFavorites');

        $em = $this->getDoctrine()->getManager();

        $favs = $em->getRepository('ProductManagementBundle:FavoriteProduct')
            ->findBy(array('user'=>$this->getUser()));

        return $this->render('ProductManagementBundle:Favorite:favoritesproduct.html.twig', array('favorites'=>$favs));
    }
    public function removeFavoriteAction(Request $request){
        $product_id = $request->get('product_id');
        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $product = $em->find('ProductManagementBundle:Product', $product_id);

        $favorite = $em->getRepository('ProductManagementBundle:FavoriteProduct')
            ->findOneBy(array('user'=>$usr, 'product'=>$product));

        $em->remove($favorite);
        $em->flush();

        return $this->redirectToRoute('list_favorite_product');
    }
}