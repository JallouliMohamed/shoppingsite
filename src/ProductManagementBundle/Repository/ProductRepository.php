<?php

namespace ProductManagementBundle\Repository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAvailableProducts($brandId){

        $enseigne = $this->getEntityManager()->find('BakeryManagementBundle:Enseigne',$brandId);

        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.enseigne = ?1')
            ->setParameter(1, $enseigne);
    }
    public function getTopSellsByBakery2($brand){
        $query = $this->getEntityManager()
            ->createQuery('select p from ProductManagementBundle:Product p WHERE p.bakery = ?1 ORDER BY p.sales DESC')
            ->setParameter(1, $brand)
            ->setMaxResults(5);

        return $query->getResult();
    }

    public function getProductsByFavorits($user){
        $em = $this->getEntityManager();
        $favs = $em->getRepository('ProductManagementBundle:Favorite')->findBy(array('user'=>$user));

        $nbr = count($favs);

        if($nbr == 0){
            return $this->getTopSells();
        }else{
            $query = $em
                ->createQuery('select p from ProductManagementBundle:Product p
                                    INNER JOIN ProductManagementBundle:Favorite f with p.subcategory = f.subcategory
                                    WHERE f.user = ?1
                                    ORDER BY p.sales DESC')
                ->setParameter(1, $user);
            return $query->getResult();
        }
    }
    public function getProductBycategory($i){
        $em = $this->getEntityManager();
        $query = $em
            ->createQuery('select p from ProductManagementBundle:Product p INNER JOIN ProductManagementBundle:SubCategory s with s = p.subcategory INNER JOIN ProductManagementBundle:Category c with c = s.category
                                                 WHERE c.id = ?1')
            ->setParameter(1, $i);
        return $query->getResult();

    }
    public function getTopRatingByBrand($brand){
        $query = $this->getEntityManager()
            ->createQuery('select p from ProductManagementBundle:Product p WHERE p.enseigne = ?1 ORDER BY p.rating DESC')
            ->setParameter(1, $brand)
            ->setMaxResults(5);

        return $query->getResult();
    }

    public function getTopRatingByBakery($bakery){
        $query = $this->getEntityManager()
            ->createQuery('select p from ProductManagementBundle:Product p WHERE p.bakery = ?1 ORDER BY p.rating DESC')
            ->setParameter(1, $bakery)
            ->setMaxResults(5);

        return $query->getResult();
    }
    public function getSimilarProducts($subcategory){
        $query = $this->getEntityManager()
            ->createQuery('select p from ProductManagementBundle:Product p WHERE p.subcategory = ?1 ORDER BY p.sales DESC')
            ->setParameter(1, $subcategory)
            ->setMaxResults(4);

        $suggestions = $query->getResult();

        return $suggestions;
    }

    public function getBakeriesWithStock($product){
        $query = $this->getEntityManager()
            ->createQuery('select s from ProductManagementBundle:Stock s where s.qte > 0 and s.product = ?1')
            ->setParameter(1, $product);
        $bakeries = $query->getResult();
        return $bakeries;
    }

    public function getProductsByPrice($min,$max){
        $query = $this->getEntityManager()
            ->createQuery('select p from ProductManagementBundle:Product p where p.price BETWEEN ?1 and ?2')
            ->setParameter(1, $min)
            ->setParameter(2, $max);
        $products = $query->getResult();
        return $products;
    }

    public function getTopSells(){
        $query = $this->getEntityManager()
            ->createQuery('select p from ProductManagementBundle:Product p ORDER BY p.sales DESC')->setMaxResults(5);

        return $query->getResult();
    }



    public function getTopSellsByBrand($brand){
        $query = $this->getEntityManager()
            ->createQuery('select p from ProductManagementBundle:Product p WHERE p.enseigne = ?1 ORDER BY p.sales DESC')
            ->setParameter(1, $brand)
            ->setMaxResults(5);

        return $query->getResult();
    }

    public function getTop3SellsByBrand($brand){
        $query = $this->getEntityManager()
            ->createQuery('select p from ProductManagementBundle:Product p WHERE p.enseigne = ?1 ORDER BY p.sales DESC')
            ->setParameter(1, $brand)
            ->setMaxResults(3);

        return $query->getResult();
    }

    public function getTopSellsByBakery($bakery){

        /*
         * select * from product
         * INNER JOIN enseigne on product.Enseigne_id=enseigne.id
         * INNER JOIN bakery on bakery.enseigne_id = enseigne.id
         * WHERE bakery.id = 1 ORDER BY product.sales DESC LIMIT 5
         */
        $query = $this->getEntityManager()
                ->createQuery('select p from ProductManagementBundle:Product p 
INNER JOIN BakeryManagementBundle:Enseigne b with p.enseigne = b 
INNER JOIN BakeryManagementBundle:Bakery ba with ba.enseigne = b
WHERE ba = ?1 ORDER BY p.sales DESC ')
            ->setParameter(1, $bakery)
            ->setMaxResults(5);

        return $query->getResult();

    }

    public function getLatestProducts(){
        $query = $this->getEntityManager()
            ->createQuery('select p from ProductManagementBundle:Product p ORDER BY p.addedAt DESC')->setMaxResults(5);

        return $query->getResult();
    }


    public function findArray($array)
    {
        $qb = $this->createQueryBuilder('product')
            ->Select('product')
            ->Where('product.id IN (:array)')
            ->setParameter('array', $array);
        return $qb->getQuery()->getResult();
    }
}
