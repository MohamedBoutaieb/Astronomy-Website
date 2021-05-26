<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\MerchOrder;
use App\Entity\Order;
use App\Entity\User;
use App\Form\EditAddressType;
use App\Form\EditPofileType;
use App\Form\EditPostType;
use App\Services\FileUploader;
use App\Services\UserSessionUpdater;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
/**
 * @Route("/account")
 */
class AccountDetailsController extends AbstractController
{
    /**
     * @Route("/" ,name="account")
     */
    public function index()
    {
        $user = $this->getUser();
        if(!$user){
            $this->addFlash('error', 'Please login to access your profile.');
            return $this->redirectToRoute('app_login');
        }
        return $this->redirectToRoute("profile");
    }

    /**
     * @Route("/settings" ,name="editprofile")
     */
    public function editProfile(Request $request, EntityManagerInterface $manager, FileUploader $fileUploader)
    {
        //gérer le formulaire
        $user = $this->getUser();
        if($user){
            $form = $this->createForm(EditPofileType::class, $user);
            $form->handleRequest($request);
            //verifier si le formulaire est valide et tout va bien et on modifie les attibuts de l'utilisateur en question
            if ($form->isSubmitted() && $form->isvalid()) {
                /** @var UploadedFile $brochureFile */
                $photoFile = $form->get('photo')->getData();
                if ($photoFile) {
                    if($user->getPhoto()!='../default_profile_picture.png'){
                        unlink($this->getParameter('profile_directory').'/'.$user->getPhoto());
                    }
                    $photoFileName = $fileUploader->upload($photoFile);
                    $user->setPhoto($photoFileName);
                }
                //remplacer l'ancien user par le nouveau
                $manager->flush();
                //message de succès
                $this->addFlash('success', 'Your Profile has been successfully updated');
                return $this->redirectToRoute('profile');
            }
        }
        else{
            $this->redirectToRoute('account');
        }
        return $this->render('account_details/editProfile.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/profile" ,name="profile")
     */
    public function showProfile(): Response
    {
        return $this->render('account_details/index.html.twig');
    }

    /**
     * @Route("/security" ,name="edit_password")
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        if ($request->isMethod('POST')) {
            if ($request->request->get('pass') == $request->request->get('confirmPass') &&
                $passwordEncoder->isPasswordValid($user, $request->request->get('oldPass'))) {
                $user->setPassword($passwordEncoder->encodePassword($user, $_POST['pass']));
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
     * @Route("/adress" ,name="edit_address")
     */
    public function editAddress(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
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
     * @Route("/articles", name="articles")
     */
    public function showArticles(EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $repository = $manager->getRepository(Article::class);
        $articles = $repository->findBy(['user' => $user]);
        return $this->render('account_details/Show_Articles.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{article}" ,name="Show_Post")
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
    public function editArticle(Request $request, EntityManagerInterface $manager, Article $article)
    {
        $user = $this->getUser();
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

    /**
     * @Route("/orders", name="orders")
     */
    public function showOrders(EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $orderRepo = $manager->getRepository(Order::class);
        $orders = $orderRepo->findBy(['buyer' => $user], ['id'=>'desc']);

        return $this->render('account_details/orders.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/order/id={order<\d+>}", name="order_details")
     */
    public function showOrderDetails(EntityManagerInterface $manager, Order $order): Response
    {
        $orderMerchRepo = $manager->getRepository(MerchOrder::class);
        $orderMerchRepo = $manager->getRepository(MerchOrder::class);
        $subOrders = $orderMerchRepo->findBy(["toOrder"=>$order], ['id'=>'desc']);
        $now =new \DateTime();
        return $this->render('account_details/order_details.html.twig', [
            'subOrders' => $subOrders,
            'order' => $order, 'date' =>  $order->getArrival()->getTimestamp()-$now->getTimestamp(),
        ]);
    }
}