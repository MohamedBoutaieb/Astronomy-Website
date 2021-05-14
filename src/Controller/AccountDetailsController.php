<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountDetailsController extends AbstractController
{
    #[Route("/account", name = "account")]
    public function index()
    {
        return $this->render('account_details/user.html.twig');
    }
//    /**
//     * @Route("/user/addpost" ,name="Add_Post")
//     */
//    public function addPost(Request $request,EntityManagerInterface $manager){
//        //avant tout on doit créer un formulaire postsType et une entité Post
//        $post= new Post();
//        $form=$this->createForm(postsType::class,$post);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isvalid()) {
//            $post->setUser($this->getUser());
//            $post->SetActive(false);
//            $manager->persist($post);
//            $manager->flush();
//            return $this->redirectToRoute();
//        }
//        return $this->render('posts/Add.html.twig',['form' =>$form->createview()]);
//    }
        //on doit créer un formulaire editType , on modifie name,firstname,phone number,
    /**
     * @Route("/account/profile" ,name="editprofile")
     */
//    public function editProfile(Request $request ,EntityManagerInterface $manager){
//       $user=$this->getUser();
//        $form=$this->createForm(editType::class,$post);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isvalid()) {
//            $post->setUser($this->getUser());
//            $post->SetActive(false);
//            $manager->persist($post);
//            $manager->flush();
//            $this->addFlash('success','This Profile has been successfully updated');
//            return $this->redirectToRoute();
//        }
//        return $this->render('account_details/editProfile.html.twig',['form' =>$form->createview()]);
//        }
//    }

}