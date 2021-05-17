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
            'posters' => $posters, 'magazines' => $magazines, 'cart' => array_count_values($session->get('cart'))
        ]);
    }

    /**
     * @Route("/nextpost",name="nextp")
     */
    public function nextpost(SessionInterface $session): Response
    {
        $index = $session->get("posterIndex");
        if ($index <= 6)
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
        if ($index <= 6)
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
            $this->addFlash("success", "insufficient stock !");
        } else {
            if (!($session->has("cart"))) {
                $cart = array();

                for ($i = 0; $i < $_POST['stock']; $i++) $arr['cart' . $i] = $merch->getId();
                $session->set("cart", $cart);
                $total = $session->get("cost") + $merch->getPrice() * $_POST['stock'];
                $session->set("cost", $total);
            } else {
                $cart = $session->get("cart");
                for ($i = 0; $i < $_POST['stock']; $i++) {
                    $index = 'cart' . (count($cart) + 1);
                    $cart[$index] = $merch->getId();
                }

            }
            $session->set("cart", $cart);
            $total = $session->get("cost") + $merch->getPrice() * $_POST['stock'];
            $session->set("cost", $total);
            $MerchRepo->modifyStock($merch->getInStock() - $_POST['stock'], $merch->getLabel())->execute();
        }


        return $this->RedirectToRoute('shop');

    }

    /**
     * @Route("/removefromcart/{id}",name="removefromcart")
     */
    public function remove($id, SessionInterface $session): Response
    {   $MerchRepo = $this->getDoctrine()->getRepository('App:Merchandise');
        $merch = $MerchRepo->findOneBy(['id' => $id]);
        $id=$merch->getId();
        if (!($session->has("cart"))) {

            $this->addFlash("success", "element not found");
        }
        else {
            $cart = $session->get("cart");

            foreach ($cart as $key => $element) {
                if (!strcmp($element, $id)) unset($cart[$key]);
            }
            $session->set("cart", $cart);

            //      $total = $session->get("cost") - $cost;
            //    $session->set("cost", $total);
            $MerchRepo->modifyStock($merch->getInStock() + $_POST['stock'], $merch->getLabel())->execute();
            $total = $session->get("cost") - $merch->getPrice() * $_POST['stock'];
            $session->set("cost", $total);
        }


        return $this->RedirectToRoute('shop');
    }

    /**
     * @Route("/removeallfromcart",name="rallfromcart")
     */
    public function removeAll(SessionInterface $session): Response
    {
        if (!($session->has("cart"))) {

            $this->addFlash("success", "cart already empty!!");
        } else {
            $MerchRepo= $this->getDoctrine()->getRepository('App:Merchandise');



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
    /**
     * @Route("/create order" ,name="create order")
     */
    public function createAccount(EntityManagerInterface $manager, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository('App:Order');
        if (($_POST['username'] == '' || $_POST['email'] == '' || $_POST['password'] == '' || $_POST['confirm'] == '')) {
            $message = "Please fill all the fields!";
            $this->addFlash("warning", $message);
        }
        elseif ($_POST['password'] != $_POST['confirm']){
            $message = "Passwords don't match!";
            $this->addFlash("warning", $message);
        }
        elseif ($repository->findOneByUsername($_POST['username'])){
            $message = "Username already exists!";
            $this->addFlash("warning", $message);
        }
        elseif ($repository->findOneByEmail($_POST['email'])){
            $message = "Email already linked to another account!";
            $this->addFlash("warning", $message);
        }
        else {
            $user = new User();
            $user->setUsername($_POST['username'])
                ->setPassword($_POST['password'])
                ->setEmail($_POST['email'])
                ->setCredits(100)
                ->setAddress(new Address());
            $manager->persist($user);
            $manager->flush();
            $message = "Your account has been created!";
            $this->addFlash("success", $message);
        }
        return $this->redirectToRoute('login', ['warning', $message]);
    }


}
