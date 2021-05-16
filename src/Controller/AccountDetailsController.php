<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Entity\Address;
use App\Form\EditAddressType;
use App\Form\EditPofileType;
use App\Form\EditPostType;
use App\Form\PostsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
class AccountDetailsController extends AbstractController
{
    /**
     * @Route("/account" ,name="account")
     */
    public function index()
    {
        return $this->redirectToRoute("profile");
    }

    /**
     * @Route("/account/settings" ,name="editprofile")
     */
    public function editProfile(Request $request, EntityManagerInterface $manager, SessionInterface $session)
    {
        //on cherche l'utilisateur avec une requête selon le username
        $user = $session->get("username");
        $repository = $manager->getRepository(User::class);
        $user = $repository->findOneByUsername($user);
        //gérer le formulaire
        $form = $this->createForm(EditPofileType::class, $user);
        $form->handleRequest($request);
        //verifier si le formulaire est valide et tout va bien et on modifie les attibuts de l'utilisateur en question
        if ($form->isSubmitted() && $form->isvalid()) {
            //remplacer l'ancien user par le nouveau
            $manager->flush();
            //message de succès
            $this->addFlash('success', 'This Profile has been successfully updated');
            return $this->redirectToRoute('profile');
        }
        return $this->render('account_details/editProfile.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/account/profile" ,name="profile")
     */
    public function showProfile(SessionInterface $session, EntityManagerInterface $manager)
    {
        //on cherche l'utilisateur avec la requête findOneByUsername
        $user = $session->get("username");
        $repository = $manager->getRepository(User::class);
        $user = $repository->findOneByUsername($user);
        return $this->render('account_details/index.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/edit/password" ,name="edit_password")
     */
    public function editPassword(SessionInterface $session, Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager)
    {
        $user = $session->get("username");
        $repository = $manager->getRepository(User::class);
        $user = $repository->findOneByUsername($user);
        if ($request->isMethod('POST')) {
            if ($request->request->get('pass') == $request->request->get('confirmPass') &&
                $request->request->get('oldPass') == $user->getPassword()) {
                $user->setPassword($_POST['pass']);
                $manager->flush();
                $this->addFlash('success', 'Password has successfully been changed.');
                return $this->redirectToRoute('profile');
            } else {
                if($request->request->get('oldPass') != $user->getPassword())
                    $this->addFlash('error', "Pleace check if you correctly typed your old password.");
                else
                    $this->addFlash('error', "Passwords don't match.");
                return $this->redirectToRoute('edit_password');
            }
        } else {
            return $this->render('account_details/editPassword.html.twig');
        }
    }

    /**
     * @Route("/edit/address" ,name="edit_address")
     */
    public function editAddress(SessionInterface $session, Request $request, EntityManagerInterface $manager)
    {
        $user = $session->get("username");
        $repository = $manager->getRepository(User::class);
        $user = $repository->findOneBy(["username" => $user]);
        $address = $user->getAddress();
        $form = $this->createForm(EditAddressType::class, $address);
        $form->handleRequest($request);
        $data = $form->getData();
        if ($form->isSubmitted() && $form->isvalid()) {
            $address->setState($data->getState())
                ->setCity($data->getCity())
                ->setZip($data->getZip())
                ->setAddress($data->getAddress());
            $manager->flush();
            $this->addFlash('success', 'Your address has been successfully updated');
            return $this->redirectToRoute('profile');
        }
        return $this->render('account_details/editAddress.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/showArticles", name="articles")
     */
    public function showArticles(SessionInterface $session, EntityManagerInterface $manager)
    {
        $user = $session->get("username");
        $repository = $manager->getRepository(Article::class);
        $articles = $repository->findBy(['user' => $user]);
        return $this->render('account_details/Show_Articles.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/showPost/{article}" ,name="Show_Post")
     */
    public function show(Article $article)
    {
        return $this->render("account_details/showArticle.html.twig", ['article' => $article]);
    }

    /**
     * @Route("/delete/post/{article}", name="article_delete")
     */
    public function deleteArticle(Article $article = null, EntityManagerInterface $manager)
    {

        if ($article) {
            $manager->remove($article);
            $manager->flush();
            $this->addFlash('success', "The post has been successfully deleted");
        } else {
            $this->addFlash('error', "The post does not exist");
        }

        return $this->redirectToRoute('articles');
    }

    /**
     * @Route("/edit/Post/{article}" ,name="edit_Post")
     */
    public function editArticle(Request $request, EntityManagerInterface $manager, SessionInterface $session, Article $article)
    {
        $user = $session->get("username");
        $repository = $manager->getRepository(User::class);
        $user = $repository->findOneByUsername($user);
        if ($article->getUser() === $user) {
            $form = $this->createForm(EditPostType::class, $article);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isvalid()) {
                $manager->flush();
                $this->addFlash('success', 'This article has been successfully updated');
                return $this->redirectToRoute('Show_Post', ['article' => $article->getId()]);
            }
            return $this->render('account_details/editArticle.html.twig', ['form' => $form->createView()]);
        }
    }
}