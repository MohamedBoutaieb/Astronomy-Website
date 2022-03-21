<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CelestialController extends AbstractController
{        /**
    * @Route("/celestial" ,name="celestial")
    */

    public function index(): Response
    {
        return $this->render('celestial/index.html.twig', [
            'controller_name' => 'CelestialController',
        ]);
    }
}
