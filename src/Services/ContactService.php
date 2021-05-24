<?php
namespace App\Services;
use App\Entity\Article;
use App\Entity\Comments;
use App\Entity\Contact;
use App\Form\CommentsType;
use App\Form\EditPofileType;
use App\Form\PostsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
class ContactService
{
   private $manager ;
   private $flash;

  public function __construct(EntityManagerInterface $manager , FlashBagInterface $flash){
      $this->manager=$manager;
      $this->flash=$flash;
  }
  public function persistContact(Contact $contact):void{
      $contact->setIsSend(false)
              ->setCreatedAt(new \DateTime('now'));
      $this->manager->persist($contact);
      $this->manager->flush();
      $this->flash->add('success','You message has been already sent.Thank you.');
  }
  public function isSend(Contact $contact):void{
      $contact->setIsSend(true);
      $this->manager->persist($contact);
      $this->manager->flush();
  }
}


