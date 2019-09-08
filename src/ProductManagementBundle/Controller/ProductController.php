<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 11/02/2018
 * Time: 3:28 PM
 */

namespace ProductManagementBundle\Controller;


use ProductManagementBundle\Entity\Product;
use ProductManagementBundle\Entity\Review;
use ProductManagementBundle\Form\ProductType;
use ProductManagementBundle\Form\ReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProductController extends Controller
{
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $bestSellers = $em->getRepository('ProductManagementBundle:Product')->getTopSells();
        return $this->render('ProductManagementBundle:Product:index.html.twig',
            array('bestSellers'=>$bestSellers));
    }


    public function getAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ens = $em->getRepository('BakeryManagementBundle:Enseigne')->findOneBy(array('user'=>$this->getUser()->getId()));
        $products = $em->getRepository('ProductManagementBundle:Product')->findBy(array('enseigne'=>$ens));
        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product, array('isEdit'=>false));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $product->setRating(0.0);
            $product->setEnseigne($ens);
            $em->persist($product);
            $em->flush();

            $bakeries = $em->getRepository('BakeryManagementBundle:Bakery')->findBy(array('enseigne'=>$ens));

            $link = $this->generateUrl('mystock_bakery', array(),UrlGeneratorInterface::ABSOLUTE_URL );
            if(!empty($bakeries)){
                foreach ($bakeries as $bakery){
                    $res = $this->forward('NotificationsBundle:Notification:addNotification',
                        array('user_id'=>$bakery->getUser()->getId(), 'msg'=>"Un nouveau produit a été ajouté", 'link'=>$link));
                }
            }

            $response = $this->forward('NotificationsBundle:SMS:notifyNewProduct', array('product_id'=>$product->getId()));
            //return $response;
            //return $this->render('ProductManagementBundle:Default:index.html.twig', array('res'=>$response));
            return $this->redirectToRoute('all_products_brand');
        }

        return $this->render('ProductManagementBundle:Product:myproductsBrand.html.twig', array('products'=>$products, 'notifications'=>$notifications,
            'form'=>$form->createView()));

    }

    public function deleteProductAction(Request $request){
        $id = $request->get('product');
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ProductManagementBundle:Product')->find($id);
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('all_products_brand');

    }

    public function editProductAction(Request $request){

        $id = $request->get('product');
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));
        $lastproduct = $em->getRepository('ProductManagementBundle:Product')->find($id);
        $product = $lastproduct;
        $form = $this->createForm(ProductType::class, $product, array('isEdit'=>true));
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            if($form['imageFile']->getData() == null){
                $product->setImageFile($lastproduct->getImageFile());
            }
            $em = $this->getDoctrine()->getManager();
            $ens = $em->getRepository('BakeryManagementBundle:Enseigne')->findOneBy(array('user'=>$this->getUser()->getId()));
            $product->setRating(0.0);
            $product->setEnseigne($ens);
            $em->persist($product);
            $em->flush();


            return $this->redirectToRoute('all_products_brand');
        }

        return $this->render('ProductManagementBundle:Product:editProduct.html.twig', array('notifications'=>$notifications,
            'form'=>$form->createView()));
    }

    public function showAllProductsAction(Request $request){
        $name = $request->request->get('name');
        $id = $request->get('subcat_id');

        $min_price = $request->get('min_price');
        $max_price = $request->get('max_price');

        $sortBy = $request->get('sortBy');

        $em = $this->getDoctrine()->getManager();
        $subcategories = $em->getRepository('ProductManagementBundle:SubCategory')->findAll();

        $bestSellers = $em->getRepository('ProductManagementBundle:Product')->getTopSells();
        $MostFavorite = $em->getRepository('ProductManagementBundle:SubCategory')->getMostLikedSubcats();

        if(!empty($name)){
            $products = $em->getRepository('ProductManagementBundle:Product')->findBy(array('name'=>$name));
        }elseif (!empty($id)){
            $subcat = $em->find('ProductManagementBundle:SubCategory', $id);

            $products = $em->getRepository('ProductManagementBundle:Product')->findBy(array('subcategory'=>$subcat));
        }elseif (!empty($min_price) && !empty($max_price)){
            $products = $em->getRepository('ProductManagementBundle:Product')->getProductsByPrice($min_price,$max_price);
        }
        else{
            $products = $em->getRepository('ProductManagementBundle:Product')->findAll();
        }

        if(!empty($sortBy)){
            if($sortBy == "popularity"){
                usort($products, function($a, $b)
                {
                    return $a->getRating() < $b->getRating();
                });
            }elseif ($sortBy == "highCost"){
                usort($products, function($a, $b)
                {
                    return $a->getPrice() < $b->getPrice();
                });
            }else{
                usort($products, function($a, $b)
                {
                    return $a->getPrice() > $b->getPrice();
                });
            }
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            9/*limit per page*/
        );

        return $this->render('ProductManagementBundle:Product:products.html.twig',
            array('products'=>$pagination, 'subcategories'=>$subcategories, 'bestSellers'=>$bestSellers, 'favs'=>$MostFavorite));

    }



    public function showProductDetailsAction(Request $request){
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('ProductManagementBundle:Product')->find($id);
        $reviews = $em->getRepository('ProductManagementBundle:Review')->findBy(array('product'=>$product));

        $stocks = $em->getRepository('ProductManagementBundle:Stock')->findBy(array('product'=>$product));

        $suggestions = $em->getRepository('ProductManagementBundle:Product')->getSimilarProducts($product->getSubCategory());

        $youMightLike = $em->getRepository('ProductManagementBundle:Product')->getProductsByFavorits($this->getUser());

        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $review->setProduct($product);
            $review->setUser($this->getUser());
            $em->persist($review);
            $em->flush();

            $res = $this->forward('ProductManagementBundle:Product:updateRating', array('id'=>$id));

            return $this->redirectToRoute('product_page', array('id'=>$product->getId()));



        }

        //$reviews = $this->forward('ProductManagementBundle:Product:showProductDetails', array('product'=>$product));
        return $this->render('ProductManagementBundle:Product:product-detail.html.twig',
            array('product'=>$product,
                'reviews'=>$reviews,
                'stocks'=>$stocks,
                'suggestions'=>$suggestions, 'youMightLike'=>$youMightLike, 'form'=>$form->createView()));
    }

    public function updateRatingAction(Request $request){
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('ProductManagementBundle:Product')->find($id);
        $reviews = $em->getRepository('ProductManagementBundle:Review')->findBy(array('product'=>$product));

        $totalWeight = 0;

        //$ratings = array_column($reviews, 'rating');
        $ratings = array_map(function($element) {
            return $element->getRating();
        },
            $reviews
        );
        $ratings = array_count_values($ratings);

        foreach ($ratings as $rating => $count){
            if($rating != null)
                $totalWeight += $rating*$count;
        }



        $averageRating = (integer)round($totalWeight/count($reviews));

        $product->setRating($averageRating);
        $em->persist($product);
        $em->flush();

        return new Response($averageRating);
    }

    public function getProductsByNameAction(Request $request){
        $name = $request->query->get('name');
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ProductManagementBundle:Product')->findBy(array('name'=>$name));

        return $this->render('ProductManagementBundle:Product:products.html.twig',
            array('products'=>$products));
    }

    public function getProductsAjaxAction(Request $request){
        $min_price = $request->get('min_price');
        $max_price = $request->get('max_price');
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ProductManagementBundle:Product')->getProductsByPrice($min_price,$max_price);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            9/*limit per page*/
        );

        $template = $this->renderView('ProductManagementBundle:Product:productView.html.twig', array('products'=>$pagination));


        return new JsonResponse($template);
    }

    /*public function getProductsBySubcatAction(Request $request){

        $id = $request->get('subcat_id');

        $em = $this->getDoctrine()->getManager();

        $subcat = $em->find('ProductManagementBundle:SubCategory', $id);

        $products = $em->getRepository('ProductManagementBundle:Product')->findBy(array('subcategory'=>$subcat));
        $values = json_encode($products);
        return $this->redirectToRoute('products_page', array('products'=>$values));
    }*/

    /*public function getProductsByPriceAction(Request $request){

        $min_price = $request->get('min_price');
        $max_price = $request->get('max_price');

        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ProductManagementBundle:Product')->getProductsByPrice($min_price,$max_price);
        $values = json_encode($products);
        return $this->redirectToRoute('products_page', array('products'=>$values));
    }*/

}