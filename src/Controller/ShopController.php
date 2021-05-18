<?php

namespace App\Controller;

use App\Entity\Merchandise;
use App\Entity\Order;
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
    {
        if (!($session->has("posterIndex"))) {
            $session->set("posterIndex", 1);
        }
        if (!($session->has("magazineIndex"))) {
            $session->set("magazineIndex", 1);
        }
        if (!($session->has("cart"))) {
            $session->set("cart", array());
        }
        if (!($session->has("cost"))) {
            $session->set("cost", 0);
        }
        //dd($this->table) ;
        $MerchRepo = $this->getDoctrine()->getRepository('App:Merchandise');

        $posters = $MerchRepo->findBy(['type' => 'Poster'], ['price' => 'asc'], 3, ($session->get("posterIndex") - 1) * 3);
        $magazines = $MerchRepo->findBy(['type' => 'magazine'], ['price' => 'asc'], 3, ($session->get("magazineIndex") - 1) * 3);
        return $this->render('shop/index.html.twig', [
            'posters' => $posters, 'magazines' => $magazines, 'cart' => ($session->get('cart'))
        ]);
    }

    /**
     * @Route("/nextpost",name="nextp")
     */
    public function nextpost(SessionInterface $session): Response
    {
        $index = $session->get("posterIndex");
        $MerchRepo = $this->getDoctrine()->getRepository('App:Merchandise');
        if ($index <= count($MerchRepo->findBy(['type' => 'Poster'])) / 3 )
            $session->set("posterIndex", $index + 1);

        return $this->RedirectToRoute('shop');
    }

    /**
     * @Route("/prevpost",name="previousp")
     */
    public function prevpost(SessionInterface $session): Response
    {

        $index = $session->get("posterIndex");
        if ($index > 1)
            $session->set("posterIndex", $index - 1);

        return $this->RedirectToRoute('shop');
    }

    /**
     * @Route("/nextmag",name="nextm")
     */
    public function nextmag(SessionInterface $session): Response
    {

        $index = $session->get("magazineIndex");
        $MerchRepo = $this->getDoctrine()->getRepository('App:Merchandise');
        if ($index <= count($MerchRepo->findBy(['type' => 'magzazine'])) / 3 )
            $session->set("magazineIndex", $index + 1);

        return $this->RedirectToRoute('shop');
    }

    /**
     * @Route("/prevmag",name="previousm")
     */
    public function prevmag(SessionInterface $session): Response
    {

        $index = $session->get("magazineIndex");
        if ($index > 1)
            $session->set("magazineIndex", $index - 1);

        return $this->RedirectToRoute('shop');
    }

    /**
     * @Route("/addtocart/{id}",name="addtocart")
     */
    public function add($id, SessionInterface $session/*,ObjectManager $manager*/): Response
    {
        $MerchRepo = $this->getDoctrine()->getRepository('App:Merchandise');
        $merch = $MerchRepo->findOneBy(['id' => $id]);
        if ($merch->getInStock() <= $_POST['stock']) {
            $this->addFlash("warning", "insufficient stock !");
        } else {
            if (!($session->has("cart"))) {
                $cart = array();

                $cart[$merch->getId()] = $_POST['stock'];

                $session->set("cart", $cart);

            } else {
                $cart = $session->get("cart");
                $cart[$merch->getId()] = $_POST['stock'];

            } //dd($cart);
            $session->set("cart", $cart);
            $total = $session->get("cost") + $merch->getPrice() * $_POST['stock'];
            $session->set("cost", $total);
            // $MerchRepo->modifyStock($merch->getInStock() - $_POST['stock'], $merch->getLabel())->execute();
        }


        return $this->RedirectToRoute('shop');

    }

    /**
     * @Route("/removefromcart/{id}",name="removefromcart")
     */
    public function remove($id, SessionInterface $session): Response
    {
        $MerchRepo = $this->getDoctrine()->getRepository('App:Merchandise');
        $merch = $MerchRepo->findOneBy(['id' => $id]);
        if (!($session->has("cart"))) {

            $this->addFlash("warning", "element not found");
        } else {
            $cart = $session->get("cart");
            $total = $session->get("cost") - $merch->getPrice() * $session->get("cart")[$id];
            $session->set("cost", $total);
            unset($cart[$id]);

            $session->set("cart", $cart);
            $this->addFlash("success", "element removed from cart ");
            //      $total = $session->get("cost") - $cost;
            //    $session->set("cost", $total);
            //$MerchRepo->modifyStock($merch->getInStock() + $_POST['stock'], $merch->getLabel())->execute();

        }


        return $this->RedirectToRoute('shop');
    }

    /**
     * @Route("/removeallfromcart",name="rallfromcart")
     */
    public function removeAll(SessionInterface $session): Response
    {
        if (!($session->has("cart"))) {

            $this->addFlash("warning", "cart already empty!!");
        } else {
            //$MerchRepo= $this->getDoctrine()->getRepository('App:Merchandise');


            $session->remove("cart");
            $session->set("cost", 0);
            $this->addFlash("success", "cart cleared!");
        }


        return $this->RedirectToRoute('shop');
    }

    /**
     * @Route("/purchase",name="purchase")
     */
    public function purchase(SessionInterface $session): Response
    {
        if (!($session->has("username"))) {
            $session->set("buyer", true);
            $this->addFlash('error', "connect to purchase your items!!");
            return $this->RedirectToRoute('login');
        } else {

            return $this->RedirectToRoute('purchasing');
        }


    }


}
