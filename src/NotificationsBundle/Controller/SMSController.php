<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 18/02/2018
 * Time: 11:10 AM
 */

namespace NotificationsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SMSController extends Controller
{

    public function sendSMS(Request $request){
        $phone = $request->get('PhoneNumber');
        $msg = $request->get('MSG');

        $twilio = $this->get('twilio.api');
        $message = $twilio->account->messages->sendMessage(
            '+12565790584', // From a Twilio number in your account
            '+216'.(string)$phone, // Text any number
            $msg
        );

        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');
        return new Response($msg);
    }


    public function notifyNewProductAction(Request $request)
    {

        $id = $request->get('product_id');
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ProductManagementBundle:Product')->find($id);
        $users = $em->getRepository('ProductManagementBundle:Favorite')->getUsersByFavorite($product->getSubCategory()->getId());

        $twilio = $this->get('twilio.api');
        $msg = $product->getEnseigne()->getName() . " a ajoute un nouveau produit dans la sous categorie " . $product->getSubCategory()->getName();

        if(count($users) != 0){
            foreach ($users as $user){
                if(!empty($user->getPhoneNumber())){
                    $message = $twilio->account->messages->sendMessage(
                        '+12565790584', // From a Twilio number in your account
                        '+216'.(string)$user->getPhoneNumber(), // Text any number
                        $msg
                    );
                }
            }
        }

        //get an instance of \Service_Twilio
        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');

        //return $message->sid;
        return new Response($msg);
    }

    public function notifyOutOfStockAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $phone = $request->get('phone');
        $productname = $request->get('productname');


        $twilio = $this->get('twilio.api');

        $msg = "Le produit ". $productname . " est Out of Stock";

        $message = $twilio->account->messages->sendMessage(
            '+12565790584', // From a Twilio number in your account
            '+216'.$phone, // Text any number
            $msg
        );

        //get an instance of \Service_Twilio
        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');

        //return $message->sid;
        return new Response($msg);
    }

}