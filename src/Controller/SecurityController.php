<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Security\RegisterFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils,SessionInterface $session): Response{

        if($this->getUser()){
                return $this->redirectToRoute("homepage");
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/create account" ,name="create account")
     */
    public function createAccount(Request $request, RegisterFormAuthenticator $registerFormAuthenticator): Response
    {
       if($request->isMethod('POST')){
           $message = $registerFormAuthenticator->createAccount($request);
           foreach ($message as $key=>$value){
               $this->addFlash($key, $value);
           }
       }

        return $this->redirectToRoute('app_login');
    }
}
