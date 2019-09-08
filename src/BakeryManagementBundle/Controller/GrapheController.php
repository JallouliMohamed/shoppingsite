<?php

namespace BakeryManagementBundle\Controller;


use Buzz\Message\Request;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\VAxis;
use ProductManagementBundle\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class GrapheController extends Controller
{
    public function chartAction()
    {
        $pieChart = new PieChart();
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('BakeryManagementBundle:Bakery')->findAll();
//        foreach ($data as $data1) {
//        $pieChart->getData()->setArrayToDataTable(
//        [
//            ['Task', 'Hours per Day'],
//            ['Work', (int)$data1->getId()],
//            ['temp libre', (int)$data1->getFax()]
//        ]);
//        }


        $pieChart->getOptions()->setTitle('You still in work');
        $pieChart->getOptions()->setHeight(400);
        $pieChart->getOptions()->setWidth(400);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#07600');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(25);

        //dump($data); die();

        return $this->render('BakeryManagementBundle:Graphe:LineChart.html.twig', array(
                'data' => $data,
            )

        );

    }

    public function TopAction()
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('ProductManagementBundle:Product')->getTopSells();

        //dump($data); die();

        return $this->render('BakeryManagementBundle:Graphe:top.html.twig', array(
                'data' => $data,));
    }
    public function TopbybrandAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $enseignes=$em->getRepository("BakeryManagementBundle:Enseigne")->findOneByuser($user);
        $data = $em->getRepository('ProductManagementBundle:Product')->getTopSellsByBrand($enseignes);

        //dump($data); die();

        return $this->render('BakeryManagementBundle:Graphe:top.html.twig', array(
            'data' => $data,));
    }
    public function TopRevbybrandAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $enseignes=$em->getRepository("BakeryManagementBundle:Enseigne")->findOneByuser($user);
        $data = $em->getRepository('ProductManagementBundle:Product')->getTopSellsByBrand($enseignes);

        //dump($data); die();

        return $this->render('BakeryManagementBundle:Graphe:TopRevenu.html.twig', array(
            'data' => $data,));
    }
    public function TopRatebybrandAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $enseignes=$em->getRepository("BakeryManagementBundle:Enseigne")->findOneByuser($user);
        $data = $em->getRepository('ProductManagementBundle:Product')->getTopRatingByBrand($enseignes);

        //dump($data); die();

        return $this->render('BakeryManagementBundle:Graphe:TopRate.html.twig', array(
            'data' => $data,));
    }
    public function BakeryProductAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $enseignes=$em->getRepository("BakeryManagementBundle:Enseigne")->findByuser($user);
        $bakery=$em->getRepository("BakeryManagementBundle:Bakery")->findByenseigne($enseignes);
        $data=array();

        foreach ($bakery as $d)
        {
            dump($d);

            $data[] = $em->getRepository('ProductManagementBundle:Product')->getTopSellsByBakery2($d);
            //array_push($tab,$data);
        }
        $size=sizeof($data);
        //dump($data); die();

        return $this->render('BakeryManagementBundle:Graphe:Bakery.html.twig', array(
            'data' => $data,'size'=>$size));
    }
    public function BakeryRevenuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $enseignes=$em->getRepository("BakeryManagementBundle:Enseigne")->findByuser($user);
        $bakery=$em->getRepository("BakeryManagementBundle:Bakery")->findByenseigne($enseignes);
        $data=array();
        foreach ($bakery as $d)
        {
            dump($d);

            $data[] = $em->getRepository('ProductManagementBundle:Product')->getTopSellsByBakery2($d);
            //array_push($tab,$data);
        }
        //dump($data); die();

        $size=sizeof($data);
        return $this->render('BakeryManagementBundle:Graphe:BakeryRev.html.twig', array(
            'data' => $data,'size'=>$size));
    }
    public function BakerychartAction(\Symfony\Component\HttpFoundation\Request $req)
    {
        $id=$req->get('id');
        $em=$this->getDoctrine()->getManager();
        $bakery=$em->getRepository("BakeryManagementBundle:Bakery")->find($id);
        $data = $em->getRepository('ProductManagementBundle:Product')->getTopSellsByBakery2($bakery);


        return $this->render('BakeryManagementBundle:Graphe:BakeryTopProduct.html.twig', array(
            'data' => $data));
    }
    public function Bakerychart2Action(\Symfony\Component\HttpFoundation\Request $req)
    {
        $id=$req->get('id');
        $em=$this->getDoctrine()->getManager();
        $bakery=$em->getRepository("BakeryManagementBundle:Bakery")->find($id);
        $data = $em->getRepository('ProductManagementBundle:Product')->getTopSellsByBakery2($bakery);


        return $this->render('BakeryManagementBundle:Graphe:BakeryTopRev.html.twig', array(
            'data' => $data));
    }
    public function BakeryToAction(\Symfony\Component\HttpFoundation\Request $req)
    {
        $id=$req->get('id');
        $em=$this->getDoctrine()->getManager();
        $bakery=$em->getRepository("BakeryManagementBundle:Bakery")->find($id);


        return $this->render('BakeryManagementBundle:Graphe:chart2.html.twig', array(
            'bakery' => $bakery));
    }
    public function BakeryRateAction(\Symfony\Component\HttpFoundation\Request $req)
    {
        $id=$req->get('id');
        $em=$this->getDoctrine()->getManager();
        $bakery=$em->getRepository("BakeryManagementBundle:Bakery")->find($id);
        $data = $em->getRepository('ProductManagementBundle:Product')->getTopRatingByBakery($bakery);


        return $this->render('BakeryManagementBundle:Graphe:chart2.html.twig', array(
            'data' => $data));
    }


}
