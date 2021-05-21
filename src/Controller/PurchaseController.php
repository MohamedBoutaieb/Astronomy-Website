<?php

namespace App\Controller;

use App\Entity\MerchOrder;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;

use http\Message;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PurchaseController extends AbstractController
{
    /**
     * @Route("/purchasing/",name="purchasing")
     */
    public function index(SessionInterface $session): Response
    { $repository = $this->getDoctrine()->getRepository('App:User');
        $user = $repository->findOneBy(['username' => $session->get('username')]);
        if (count($session->get('cart'))==0) {
            $message = "Your cart is empty!";
            $this->addFlash("danger", $message);
            return $this->RedirectToRoute('shop');
        }

        if ( is_null($user->getAddress()) ){
            $message = "You must add an address !";
            $this->addFlash("success", $message);
            return $this->RedirectToRoute('edit_address');
        }
        return $this->render('purchase/index.html.twig', [
           'cart' => ($session->get('cart1')),'address'=>$user->getAddress()
        ]);
    }
    /**
     * @Route("/create order" ,name="create order")
     */
    public function createOrder(EntityManagerInterface $manager ,SessionInterface $session, Request $request): Response
    {   $userRepository = $this->getDoctrine()->getRepository('App:User');
        $merchRepository = $this->getDoctrine()->getRepository('App:Merchandise');
        $user = $userRepository->findOneBy(['username' => $session->get('username')]);

        if ($user->getCredits()< $session->get('cost'))
        {
            $message = "insufficient funds !";
            $this->addFlash("danger", $message);
            return $this->RedirectToRoute('shop');
        }
        else {
            foreach ( $session->get('cart') as $id=>$qt )
            {  $quantity = ($merchRepository->findOneBy(['id'=>$id]))->getInStock();
                if ($quantity< $qt) {
                    $message = "insufficient item : $id quantity change your odrer  !";
                    $this->addFlash("danger", $message);
                    return $this->RedirectToRoute('shop');

                }
            }
            $order = new Order();
            $order->setBuyer($user)->setCost($session->get('cost'))->setAddress($user->getAddress())->setDate()->setArrival();

            $manager->persist($order);
            $manager->flush();

            foreach ( $session->get('cart') as $id=>$qt )
            {  $merch = $merchRepository->findOneBy(['id'=>$id]);
                $merchRepository->modifyStock($merch->getInStock() - $qt, $merch->getLabel())->execute();
                $merchOrder= new MerchOrder();
                $merchOrder->setToMerch($merch)->setQuantity($qt)->setToorder($order);
                $manager->persist($merchOrder);
                $manager->flush();
            }
            $message="your purchase has been done successfully , check your account for more details";
            $this->addFlash("success", $message);
            $user->setCredits($user->getCredits()-$session->get('cost'));
            $manager->persist($user);
            $manager->flush();

            return $this->RedirectToRoute('rallfromcart');


        }

        /*foreach ($session->get('cart') as $id =>$quantity ){
            $order = new Order();
            $order->setBuyer($repository->findOneByUsername($session->get('username')))
                ->setCost($session->get('cost'))
                ->setTotalQuantity($_POST[$quantity.$id])
                ->setMerch($_POST[$id]);
            $manager->persist($order);
            $manager->flush();}
        $message = "Your order has been created!";
        $this->addFlash("success", $message); */



    }
}
