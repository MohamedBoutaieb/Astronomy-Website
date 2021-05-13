<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPassType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ResetPasswordController extends AbstractController
{
    #[Route('/forgot/password', name: 'forgot_password')]
    public function index(Request $request ,EntityManagerInterface $manager ,UserRepository $userRepository
        , \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        //create form
        $form = $this->createForm(ResetPassType::class);
        //traitement formulaire
        $form->handleRequest($request);
        //si le formulaire est valide
        if ($form->isSubmitted() && $form->isvalid()) {
            //récupérer les données
            $data = $form->getData();
            $user=$userRepository->findOneByEmail($data['email']);
            if(!$user){
                $this->addFlash('warning','This email does not exist');
               return $this->redirectToRoute('login');
            }
            $token=$tokenGenerator->generateToken();
            try{
                $user->setResetToken($token);
                $manager->persist($user);
                $manager->flush();}
            catch(\Exception $e){
               $this->addFlash('warning','An error has occurred:'.$e->getMessage() );
                return $this->redirectToRoute('login');
            }
            //je vais générer l'url de réinitialisation
        $url=$this->generateUrl('reset_password' ,['token'=>$token],UrlGeneratorInterface::ABSOLUTE_URL);
            //je vais envoyer le msg
        $message= (new \Swift_Message('Reset Password'))
                ->setFrom('azizazouz8b1@gmail.com')
                ->setTo($user->getEmail())
                ->setTo('ferielbouhamed@insat.u-carthage.tn')
                ->setTo('mohamedazizkhayati@insat.u-carthage.tn')
                ->setBody(
                    "<p>Hello,</p><p>a request for password renitialisation has been made for the
                    site Astronomy Magazine please click on the following link:".$url .'</p>','text/html');
        //j'envoie l'email
        $mailer->send($message);
              $this->addFlash('message','A password reset email was sent to you');
              return $this->redirectToRoute('login');

        }
        return $this->render('reset_password/forgottenpassword.html.twig',['emailForm'=>$form->createview()]);
    }
    /**
     * @Route("/reset_password/{token}" ,name="reset_password")
     */
    public function resetPassword(EntityManagerInterface $manager,$token , Request $request,UserPasswordEncoderInterface $passwordEncoder){
        //je cherche l'utilisateur avec le token
        $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token'=>$token]);
        if(!$user){
            $this->addFlash('warning','User does not exist');
            return $this->redirectToRoute('login');}
        if($request->isMethod('POST')){
            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user,$request->request->get('password')));
            //$user->setPassword($request->request->get('password'));
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success','Password has successfully been changed.');
            return $this->redirectToRoute('login');
        }else{
            return $this->render('reset_password/reset_password.html.twig',['token'=>$token]);
        }
    }
}

