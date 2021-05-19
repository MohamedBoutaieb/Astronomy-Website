<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/search/page={page<\d+>?1}" ,name="search")
     */
    public function search (EntityManagerInterface $manager, Request $request, $page): Response
    {
        $a="h";
        $userRepo = $manager->getRepository('App:User');
        if($request->isMethod("get")){
            $users = $userRepo->search($_GET["user"]);

            return $this->redirectToRoute('searchpage');
        }
        else{
            return $this->redirectToRoute('searchpage');
        }
    }
}
