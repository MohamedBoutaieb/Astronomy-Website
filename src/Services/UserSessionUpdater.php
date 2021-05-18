<?php


namespace App\Services;


use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserSessionUpdater
{
    private $session, $registry;
    public function __construct(SessionInterface $session, ManagerRegistry $registry){
        $this->session = $session;
        $this->registry = $registry;
    }
    public function updateUserSession(){
        if($this->session->has('username')){
            $repository = $this->registry->getRepository(User::class);
            $user = $repository->findOneByUsername($this->session->get('username'));
            $this->session->set('user', $user);
            return $user;
        }
        return null;
    }
}