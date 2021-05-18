<?php

namespace App\Controller;

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

        if ( is_null($user->getAddress()) ){
            $message = "You must add an address !";
            $this->addFlash("success", $message);
            return $this->RedirectToRoute('edit_address');
        }
        return $this->render('purchase/index.html.twig', [
           'cart' => ($session->get('cart')),'address'=>$user->getAddress()
        ]);
    }
    /**
     * @Route("/create order" ,name="create order")
     */
    public function createOrder(EntityManagerInterface $manager ,SessionInterface $session, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository('App:User');
        foreach ($session->get('cart') as $id =>$quantity ){
            $order = new Order();
            $order->setBuyer($repository->findOneByUsername($session->get('username')))
                ->setCost($session->get('cost'))
                ->setTotalQuantity($_POST[$quantity.$id])
                ->setMerch($_POST[$id]);
            $manager->persist($order);
            $manager->flush();}
        $message = "Your order has been created!";
        $this->addFlash("success", $message);

        return $this->render('purchase/index.html.twig', [
            'controller_name' => 'PurchaseController',
        ]);
    }
}
