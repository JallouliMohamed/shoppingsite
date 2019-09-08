<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 14/02/2018
 * Time: 7:16 PM
 */

namespace ProductManagementBundle\Controller;


use ProductManagementBundle\Entity\Favorite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FavoriteController extends Controller
{
    public function addFavoriteAction(Request $request){

        $id = $request->get('subcategory');
        $em = $this->getDoctrine()->getManager();
        $subcategory = $em->getRepository('ProductManagementBundle:SubCategory')->find($id);
        $favorite = $em->getRepository('ProductManagementBundle:Favorite')
            ->findOneBy(array('subcategory'=>$subcategory, 'user'=>$this->getUser()));
        if(empty($favorite)){
            $favorite = new Favorite($this->getUser(), $subcategory);
            $em->persist($favorite);
            $em->flush();

        }

        return $this->redirectToRoute('categories_page');
    }


    public function getMyFavoritesAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $favorites = $em->getRepository('ProductManagementBundle:Favorite')
            ->findBy(array('user'=>$this->getUser()));

        return $favorites;
    }

    public function listFavoriteAction(Request $request){
        //$favs = $this->forward('ProductManagementBundle:Favorite:getMyFavorites');

        $em = $this->getDoctrine()->getManager();

        $favs = $em->getRepository('ProductManagementBundle:Favorite')
            ->findBy(array('user'=>$this->getUser()));

        return $this->render('ProductManagementBundle:Favorite:favorites.html.twig', array('favorites'=>$favs));
    }

    public function removeFavoriteAction(Request $request){
        $subcat_id = $request->get('subcat_id');

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $subcat = $em->find('ProductManagementBundle:SubCategory', $subcat_id);

        $favorite = $em->getRepository('ProductManagementBundle:Favorite')
            ->findOneBy(array('user'=>$user, 'subcategory'=>$subcat));

        $em->remove($favorite);
        $em->flush();

        return $this->redirectToRoute('list_favorite');
    }
}