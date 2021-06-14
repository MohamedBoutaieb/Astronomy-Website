<?php

# src/EventSubscriber/EasyAdminSubscriber.php
namespace App\EventSubscriber;

use App\Entity\Article;
use App\Entity\Comments;
use App\Entity\Contact;
use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $slugger;
    private $security;


    public function __construct(SluggerInterface $slugger, Security $security)
    {
        $this->security=$security;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setDateAndUser'],
        ];
    }

    public function setDateAndUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (($entity instanceof Article)) {
            $now = new DateTime('now');
            $entity->setCreatedAt($now);
            $user = $this->security->getUser();
            $entity->setUser($user);
        }
        else if (($entity instanceof Order)) {
            $now = new DateTime('now');
            $entity->setCreatedAt($now);
            $user = $this->security->getUser()->getUsername();
            $entity->setBuyer($user);
            $entity->setAddres($this->security->getUser()->getAddress());
        }
        else if($entity instanceof Contact){
            $now = new DateTime('now');
            $entity->setCreatedAt($now);
        }
        return;
    }
}


