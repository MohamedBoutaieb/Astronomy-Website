<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/search/page={page<\d+>?1}" ,name="search")
     */
    public function search (EntityManagerInterface $manager,SessionInterface $session ,Request $request, $page): Response
    {

        $userRepo = $manager->getRepository('App:User');
        if($request->isMethod("get")){
            if (isset($_GET["user"]))
            {$session->set('keysearch',$_GET["user"]);}
            $users = $userRepo->search($session->get('keysearch'));



          if ($users!=null)
            return $this->render('profile/search_result.html.twig', [
               'users'=> $users
            ]);
            $message= " No user was found";
            $this->addFlash("danger", $message);
            return $this->redirectToRoute('homepage');
        }
        else{
            return $this->redirectToRoute('homepage');
        }
    }
    /**
     * @Route("/details/{id}" ,name="details")
     */
    public function profileDetails(EntityManagerInterface $manager,$id, Request $request,SessionInterface $session): Response
    { $userRepo = $manager->getRepository('App:User');
        $user = $userRepo->findOneBy(['username'=>$id]);

        return $this->render('profile/index.html.twig', [
            'user'=> $user
        ]);
    }


}
