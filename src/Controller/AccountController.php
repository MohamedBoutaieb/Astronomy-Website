<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Entity\Account;
use App\Form\AccountFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/form")
     *
     */
    public function index(Request $request,EntityManagerInterface  $entityManager):Response
    {
        $account = new Account();
        $form = $this->createForm(AccountFormType::class,$account);
        $form->handleRequest ($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($account);
            $entityManager->flush();
            return new Response('subscriber created' );
        }
        return $this->render('account/show.html.twig',
        ['subscriber_form' => $form->createView()]);
    }
}
