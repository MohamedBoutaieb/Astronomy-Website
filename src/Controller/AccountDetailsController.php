<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Address;
use App\Form\EditAddressType;
use App\Form\EditPofileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        $form = $this->createForm(EditPofileType::class);
        $form->handleRequest($request);
        $data = $form->getData();
        //verifier si le formulaire est valide et tout va bien et on modifie les attibuts de l'utilisateur en question
        if ($form->isSubmitted() && $form->isvalid()) {
            $user->setFirstname($data->getFirstname());
            $user->setLastname($data->getLastname());
            $user->setEmail($data->getemail());
            $user->setPhoneNumber($data->getPhoneNumber());
            $user->setAddress($data->getAddress());
            //remplacer l'ancien user par le nouveau
            //$manager->persist($data);
            $manager->flush();
            //message de succès
            $this->addFlash('success', 'This Profile has been successfully updated');
            return $this->redirectToRoute('profile');
        }
        return $this->render('account_details/editProfile.html.twig', ['form'=>$form->createView()]);
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
            if ($request->request->get('pass') == $request->request->get('Confirm_Pass')) {
                $user->setPassword($_POST['pass']);
               // $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('Password')));
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Password has successfully been changed.');
                return $this->redirectToRoute('profile');
            } else {
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
        $user = $repository->findOneBy(["username"=>$user]);
        $address = $user->getAddress();
        $form = $this->createForm(EditAddressType::class,$address);
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
        return $this->render('account_details/editProfile.html.twig', ['form'=>$form->createView()]);
    }
}