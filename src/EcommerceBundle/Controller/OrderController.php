<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\LineOrder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EcommerceBundle\Entity\Orders;
use Symfony\Component\HttpFoundation\Request;
use ProductManagementBundle\Controller\ProductController;
use ProductManagementBundle\Entity\Product;
use UsersBundle\Entity\Adresses;
use Symfony\Component\HttpFoundation\Response;
use Knp\Snappy\Pdf;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use JMS\Payment\CoreBundle\PluginController\Result;

use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use EcommerceBundle\Entity\Planning;
class OrderController extends Controller
{



    public function factureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$generator = $this->container->get('security.secure_random');
        $session = $request->getSession();
        $panier = $session->get('panier');
        $adresse = $session->get('adresse');
        $commande = array();
        $totalHT = 0;
        $totalTVA = 0;

        $facturation = $em->getRepository('UsersBundle:Adresses')->find($adresse['facturation']);
        $livraison = $em->getRepository('UsersBundle:Adresses')->find($adresse['livraison']);
        $produits = $em->getRepository('ProductManagementBundle:Product')->findArray(array_keys($session->get('panier')));

        foreach($produits as $produit)
        {

            $prixHT = ($produit->getPrice() * $panier[$produit->getId()]);
            //$prixTTC = ($produit->getPrice() * $panier[$produit->getId()] / $produit->getTva()->getMultiplicate());
            $totalHT += $prixHT;

         /*   if (!isset($commande['tva']['%'.$produit->getTva()->getValeur()]))
                $commande['tva']['%'.$produit->getTva()->getValeur()] = round($prixTTC - $prixHT,2);
            else
                $commande['tva']['%'.$produit->getTva()->getValeur()] += round($prixTTC - $prixHT,2);

            $totalTVA += round($prixTTC - $prixHT,2);*/

            $commande['produit'][$produit->getId()] = array('reference' => $produit->getName(),
                'id' => $produit->getId(),
                'quantite' => $panier[$produit->getId()],
                'prixHT' => round($produit->getPrice(),2),
                );
        }

        $commande['livraison'] = array('prenom' => $livraison->getPrenom(),
            'nom' => $livraison->getNom(),
            'telephone' => $livraison->getTelephone(),
            'adresse' => $livraison->getAdresse(),
            'cp' => $livraison->getCp(),
            'ville' => $livraison->getVille(),
            'pays' => $livraison->getPays(),
            'complement' => $livraison->getComplement());

        $commande['facturation'] = array('prenom' => $facturation->getPrenom(),
            'nom' => $facturation->getNom(),
            'telephone' => $facturation->getTelephone(),
            'adresse' => $facturation->getAdresse(),
            'cp' => $facturation->getCp(),
            'ville' => $facturation->getVille(),
            'pays' => $facturation->getPays(),
            'complement' => $facturation->getComplement());

        $commande['prixHT'] = round($totalHT,2);
        $commande['prixTTC'] = round($totalHT + $totalTVA,2);
        $commande['token'] = bin2hex(random_bytes(20));

        return $commande;
    }






    public function prepareCommandeAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $panier = $session->get('panier');


        /*
                if (!$session->has('commande'))
                    $commande = new Orders();
                else
                    //$commande = $em->getRepository('EcommerceBundle:Orders')->find($session->get('commande'));
               $commande=$em->find(Orders::class, $session->get('commande','Orders'));*/
        $adresse = $session->get('adresse');
        $produits = $em->getRepository('ProductManagementBundle:Product')->findArray(array_keys($session->get('panier')));
        $livraison = $em->getRepository('UsersBundle:Adresses')->find($adresse['livraison']);
        $commande = new Orders();
        $time = new \DateTime();
       // echo $time->format('H:i:s \O\n Y-m-d');

        $commande->setOrder($this->factureAction($request));
        $commande->setDate(new \DateTime());
        $commande->setUser($this->getUser());
        $commande->setPaymentstate("notpaid");
        $commande->setReference("CUPCAKE-".random_int(1000, 9999999)."-".$time->format('Y'));
        $commande->setAdresse($livraison);
        $amount=0;
        foreach($produits as $produit)
        {
            $lineorder= new LineOrder();
            $lineorder->setProduct($produit);
            $lineorder->setQte($panier[$produit->getId()]);
            $lineorder->setOrder($commande);
            //$commande->setLineorder($lineorder);

           $amount=$amount+($produit->getPrice() * $panier[$produit->getId()]);
            $commande->setAmount($amount);

            $em->persist($lineorder);
            $em->flush();
        }

       /* if (!$session->has('commande')) {
            $em->persist($commande);
            $session->set('commande',$commande);
        }*/
        $em->persist($commande);
        $em->flush();


        return new Response($commande->getId());
    }
    public function listOrdersAction()
    {

        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('EcommerceBundle:Orders')->findBy(array('utilisateur' => $this->getUser()->getId()));



        return $this->render('@Users/listorders.html.twig', array('orders'=>$orders));
    }


    public function BakerylistOrdersAction()
    {

        $em = $this->getDoctrine()->getManager();
        $bakery = $em->getRepository('BakeryManagementBundle:Bakery')->findBy(array('user' => $this->getUser()->getId()));
        $products = $em->getRepository('ProductManagementBundle:Product')->findBy(array('bakery' => $bakery));
        $lineorders = $em->getRepository('EcommerceBundle:LineOrder')->findBy(array('product' => $products));
        $plannings = $em->getRepository('EcommerceBundle:Planning')->findOneBy(array('lineorder' => $lineorders));
        $planning1 = $em->getRepository('EcommerceBundle:Planning')->findby(array('lineorder' => $lineorders));
dump($bakery);


        return $this->render('@Ecommerce/listlineorders.html.twig', array('lineorders'=>$lineorders,
            'plannings'=>$plannings,
            'plan'=>$planning1
            ));
    }
    public function afficherFactureAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $commande = $em->getRepository('EcommerceBundle:Orders')->find($id);
        if($commande==null)
        {
            return $this->redirectToRoute('userallorders');
        }
        if($commande->getUser()!=$this->getUser() or $commande==null)
        {
            return $this->redirectToRoute('userallorders');
        }

        return $this->render('@Ecommerce/showfacture.html.twig', array('commande' => $commande));
    }
    public function FacturePDFAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $commande = $em->getRepository('EcommerceBundle:Orders')->find($id);
        //$this->render('@Ecommerce/showfacture.html.twig', array('commande' => $commande));


        $snappy = new Pdf('/usr/local/bin/wkhtmltopdf');

        $html = $this->renderView('@Ecommerce/facturepdf.html.twig', array(
            'title' => 'Facture',
            'commande' => $commande,
            'base_dir' => $this->get('kernel')->getRootDir() . '/../web' . $request->getBasePath(),
            'title' => 'Facture'
        ));

        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }

    private function createPayment($order)
    {
        $instruction = $order->getPaymentInstruction();
        $pendingTransaction = $instruction->getPendingTransaction();

        if ($pendingTransaction !== null) {
            return $pendingTransaction->getPayment();
        }

        $ppc = $this->get('payment.plugin_controller');
        $amount = $instruction->getAmount() - $instruction->getDepositedAmount();

        return $ppc->createPayment($instruction->getId(), $amount);
    }

    public function PaymentAction(Request $request, \EcommerceBundle\Entity\Orders $order)
    {
        $config = [
            'paypal_express_checkout' => [
                'return_url' => $this->generateUrl('app_orders_paymentcreate', ['id' => $order->getId(),], UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' => $this->generateUrl('homepage', ['id' => $order->getId(),], UrlGeneratorInterface::ABSOLUTE_URL),
                'useraction' => 'commit'
            ],
        ];
        $form = $this->createForm(ChoosePaymentMethodType::class, null, [
            'amount'   => $order->getAmount(),
            'currency' => 'USD',
            'predefined_data' => $config,
            'choice_options' => [
                'expanded' => false,
            ],
            'method_options' => [
                'paypal_express_checkout' => [
                    'label' => false,
                ],
            ],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ppc = $this->get('payment.plugin_controller');
            $ppc->createPaymentInstruction($instruction = $form->getData());

            $order->setPaymentInstruction($instruction);

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush($order);

            return $this->redirect($this->generateUrl('app_orders_paymentcreate', [
                'id' => $order->getId(),
            ]));
        }

        return $this->render('@Ecommerce/showpayment.html.twig', array(
            'order' => $order,
            'form'=>$form->createView()));

    }

    public function paymentCreateAction(\EcommerceBundle\Entity\Orders $order)
    {
        $payment = $this->createPayment($order);

        $ppc = $this->get('payment.plugin_controller');
        $result = $ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());

        if ($result->getStatus() === Result::STATUS_SUCCESS) {
            return $this->redirect($this->generateUrl('app_orders_paymentcomplete', [
                'id' => $order->getId(),
            ]));
        }
        if ($result->getStatus() === Result::STATUS_PENDING) {
            $ex = $result->getPluginException();

            if ($ex instanceof ActionRequiredException) {
                $action = $ex->getAction();

                if ($action instanceof VisitUrl) {
                    return $this->redirect($action->getUrl());
                }
            }
        }

        return $this->redirectToRoute('homepage');
        // In a real-world application you wouldn't throw the exception. You would,
        // for example, redirect to the showAction with a flash message informing
        // the user that the payment was not successful.
    }

    public function paymentCompleteAction(Orders $order)
    {


        $order->setPaymentstate('paid');
        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();
        return $this->redirect($this->generateUrl('afficherfacture', [
            'id' => $order->getId(),
        ]));
    }


}
