<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Services\ContactService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact",name="contact")
     */
    public function index(Request $request, ContactService  $contactService)
    {   $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isvalid()) {
            $contact=$form->getData();
           $contactService->persistContact($contact);
           return $this->redirectToRoute('contact');
        }
        return $this->render('contact/index.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
