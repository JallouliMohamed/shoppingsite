<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 12/02/2018
 * Time: 3:40 PM
 */

namespace ProductManagementBundle\Controller;


use ProductManagementBundle\Entity\Stock;
use ProductManagementBundle\Form\StockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StockController extends Controller
{
    public function getMyStockAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $bakery = $em->getRepository('BakeryManagementBundle:Bakery')->findOneBy(array('user'=>$this->getUser()->getId()));
        $stocks = $em->getRepository('ProductManagementBundle:Stock')->findBy(array('bakery'=>$bakery));

        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));

        $stock = new Stock();

        $form = $this->createForm(StockType::class, $stock, array('BrandId'=>1,'isEdit'=>false));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // check if product already exists in stock
            $productInStock = $em->getRepository('ProductManagementBundle:Stock')
                ->findOneBy(array('product'=>$stock->getProduct()));



            if(!empty($productInStock)){
                // update stock
                $productInStock->setQte($productInStock->getQte() + $stock->getQte());
                $em->persist($productInStock);
            }else{
                $stock->setBakery($bakery);
                $em->persist($stock);
            }

            $em->flush();

            return $this->redirectToRoute('mystock_bakery');
        }

        return $this->render('ProductManagementBundle:Stock:mystock.html.twig',
            array('stocks'=>$stocks, 'notifications'=>$notifications,
            'form'=>$form->createView()));
    }

    public function removeStockAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $bakery = $em->getRepository('BakeryManagementBundle:Bakery')->findOneBy(array('user'=>$this->getUser()->getId()));
        $product = $em->getRepository('ProductManagementBundle:Product')->find($request->get('product'));
        $stock = $em->getRepository('ProductManagementBundle:Stock')
            ->findOneBy(array('product'=>$product, 'bakery'=>$bakery));

        $em->remove($stock);
        $em->flush();
        return $this->redirectToRoute('mystock_bakery');
    }

    public function editStockAction(Request $request){
        $productId = $request->get('productId');

        $em = $this->getDoctrine()->getManager();
        $bakery = $em->getRepository('BakeryManagementBundle:Bakery')->findOneBy(array('user'=>$this->getUser()->getId()));
        $product = $em->getRepository('ProductManagementBundle:Product')->find($productId);

        $stock = $em->getRepository('ProductManagementBundle:Stock')->findOneBy(array('bakery'=>$bakery,'product'=>$product));
        $notifications = $em->getRepository('NotificationsBundle:Notification')->findBy(array('user'=>$this->getUser(), 'isRead'=>false));


        $form = $this->createForm(StockType::class, $stock, array('BrandId'=>1,'isEdit'=>true));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($stock);
            $em->flush();

            if($stock->getQte()<=0){
                $response = $this->forward('NotificationsBundle:SMS:notifyOutOfStock',
                    array('productname'=>$product->getName(), 'phone'=>$bakery->getUser()->getPhoneNumber()));

                $link = $this->generateUrl('mystock_bakery', array(),UrlGeneratorInterface::ABSOLUTE_URL );
                $res = $this->forward('NotificationsBundle:Notification:addNotification',
                    array('user_id'=>$bakery->getUser()->getId(), 'msg'=>"Veuillez vérifier le stock de ". $product->getName(), 'link'=>$link));
            }

            return $this->redirectToRoute('mystock_bakery');
        }

        return $this->render('ProductManagementBundle:Stock:editStock.html.twig', array('notifications'=>$notifications,'form'=>$form->createView()));
    }

    public function updateStockAfterOrderAction(Request $request){
        $productId = $request->get('productId');
        $bakeryId = $request->get('bakeryId');
        $orderQte = (int) $request->get('orderQte');

        $em = $this->getDoctrine()->getManager();
        $bakery = $em->getRepository('BakeryManagementBundle:Bakery')->find($bakeryId);
        $product = $em->getRepository('ProductManagementBundle:Product')->find($productId);
        $stock = $em->getRepository('ProductManagementBundle:Stock')->findOneBy(array('bakery'=>$bakery,'product'=>$product));

        $stock->setQte($stock->getQte()-$orderQte);
        $em->persist($stock);
        $em->flush();

        if($stock->getQte()<=0){
            $response = $this->forward('NotificationsBundle:SMS:notifyOutOfStock',
                array('productname'=>$product->getName(), 'phone'=>$bakery->getUser()->getPhoneNumber()));

            $link = $this->generateUrl('mystock_bakery', array(),UrlGeneratorInterface::ABSOLUTE_URL );
            $res = $this->forward('NotificationsBundle:Notification:addNotification',
                array('user_id'=>$bakery->getUser()->getId(), 'msg'=>"Veuillez vérifier le stock de ". $product->getName(), 'link'=>$link));
        }
        return new Response("Stock Updated");
    }
}