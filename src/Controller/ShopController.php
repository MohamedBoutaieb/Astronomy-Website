<?php

namespace App\Controller;

use App\Entity\Merchandise;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{

    /**
     * @Route("/shop" ,name="shop")
     */
    public function index(SessionInterface $session): Response
    {  if (!($session->has("posterIndex"))){
        $session->set("posterIndex",1);}
        if (!($session->has("magazineIndex"))){
            $session->set("magazineIndex",1);}
        if (!($session->has("cart"))){
            $session->set("cart",array());}
        if (!($session->has("cost"))){
            $session->set("cost",0);}
        //dd($this->table) ;
        $MerchRepo= $this->getDoctrine()->getRepository('App:Merchandise');

        $posters= $MerchRepo->findBy(['type'=>'Poster'],['price'=>'asc'],3,($session->get("posterIndex")- 1)*3);
        $magazines= $MerchRepo->findBy(['type'=>'magazine'],['price'=>'asc'],3,($session->get("magazineIndex")- 1)*3);
        return $this->render('shop/index.html.twig', [
            'posters' => $posters,'magazines'=>$magazines,'cart'=>array_count_values($session->get('cart'))
        ]);
    }
    /**
     * @Route("/nextpost",name="nextp")
     */
    public function nextpost(SessionInterface $session): Response
    {
        $index = $session->get("posterIndex");
        if ($index <= 6)
        $session->set("posterIndex",$index+1);

        return $this-> RedirectToRoute('shop');
    }
    /**
     * @Route("/prevpost",name="previousp")
     */
    public function prevpost(SessionInterface $session): Response
    {

        $index = $session->get("posterIndex");
        if ($index > 1)
        $session->set("posterIndex",$index-1);

        return $this-> RedirectToRoute('shop');
    }
    /**
     * @Route("/nextmag",name="nextm")
     */
    public function nextmag(SessionInterface $session): Response
    {
        $index = $session->get("magazineIndex");
        if ($index <= 6)
            $session->set("magazineIndex",$index+1);

        return $this-> RedirectToRoute('shop');
    }
    /**
     * @Route("/prevmag",name="previousm")
     */
    public function prevmag(SessionInterface $session): Response
    {

        $index = $session->get("magazineIndex");
        if ($index > 1)
            $session->set("magazineIndex",$index-1);

        return $this-> RedirectToRoute('shop');
    }
    /**
     * @Route("/addtocart/{item}/{cost}/{stock}",name="addtocart")
     */
    public function add($item,$cost,$stock,SessionInterface $session/*,ObjectManager $manager*/): Response
    { if (!($session->has("cart"))){
        if ($stock>=1)
        { $session->set("cart",array('cart1'=> $item));

        //$MerchRepo= $this->getDoctrine()->getRepository('App:Merchandise');
        //$MerchRepo->modifyStock($stock-1,$item);
            }
        else
            $this->addFlash("success", "out of stock !");
    }
      else {
            $cart=$session->get("cart");
            $index='cart'.(count($cart)+1);
            $cart[$index]=$item;
            $session->set("cart",$cart);
          $total=$session->get("cost")+$cost;
          $session->set("cost",$total);

        }


        return $this-> RedirectToRoute('shop');
    }
    /**
     * @Route("/removefromcart/{item}/{cost}",name="rfromcart")
     */
    public function remove($item,$cost,SessionInterface $session): Response
    {
        if (!($session->has("cart"))){

        $this->addFlash("success", "element not found");}
    else {
        $cart=$session->get("cart");
        if (isset($cart[$item])) {
            //$MerchRepo= $this->getDoctrine()->getRepository('App:Merchandise');
            //$MerchRepo->modifyStock($stock+1,$item);
            unset($cart[$item]);
            $session->set("cart",$cart);

            $total=$session->get("cost")-$cost;
            $session->set("cost",$total);}
        else  $this->addFlash("success", "element removed successfully");
        }


        return $this-> RedirectToRoute('shop');
    }
    /**
     * @Route("/removeallfromcart",name="rallfromcart")
     */
    public function removeAll(SessionInterface $session): Response
    {
        if (!($session->has("cart"))){

            $this->addFlash("success", "cart already empty!!");}
        else {
            //$MerchRepo= $this->getDoctrine()->getRepository('App:Merchandise');
            // for item in items $MerchRepo->modifyStock($stock+1,$item);
            $session->remove("cart");
            $session->set("cost",0);
            $this->addFlash("success", "cart cleared!");
        }


        return $this-> RedirectToRoute('shop');
    }
    /**
     * @Route("/purchase",name="purchase")
     */
    public function purchase(SessionInterface $session): Response
    {
        if (!($session->has("username"))){
            $session->set("buyer",true);
            return $this-> RedirectToRoute('login');
            $this->addFlash("connect to purchase your items!!");}
        else {
            return $this-> RedirectToRoute('purchasings');
        }



    }

}
