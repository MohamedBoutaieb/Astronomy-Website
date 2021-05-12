<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Message;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/create account" ,name="create account")
     */
    public function createAccount(EntityManagerInterface $manager, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository('App:User');
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
                ->setCredits(100);
            $manager->persist($user);
            $manager->flush();
            $message = "Your account has been created!";
            $this->addFlash("success", $message);
        }
        return $this->redirectToRoute('login', ['warning', $message]);
    }

    /**
     * @Route("/login" ,name="login")
     */
    public function index(Request $request, SessionInterface $session): Response
    {
        $repository = $this->getDoctrine()->getRepository('App:User');
        if($session->has("username")){
            return $this->redirectToRoute('homepage');
        }
        if(isset($_POST["username"])){
            $user = $repository->findOneByUsername($_POST["username"]);
            if(!$user)
                $user = $repository->findOneByEmail($_POST["username"]);
            if(!$user){
                $message = "Username or password incorrect!";
                $this->addFlash("error", $message);
            }
            elseif($user->getPassword() != $_POST["password"]){
                $message = "Username or password incorrect!";
                $this->addFlash("error", $message);
            }
            else {
                $session->set('username', $user->getUsername());
                return $this->redirectToRoute('homepage',[]);
            }
        }
        return $this->render('login/index.html.twig');
    }

    /**
     * @Route("/logout",name="logout")
     */
    public function logout(SessionInterface $session){
        $session->remove("username");
        return $this->redirectToRoute('login');
    }
}