<?php


namespace App\Services;


use App\Entity\Article;
use App\Entity\Comments;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class CommentService
{
    private $manager ;
    private $flash;

    public function __construct(EntityManagerInterface $manager , FlashBagInterface $flash){
        $this->manager=$manager;
        $this->flash=$flash;
    }
    public function persistComment(Comments $comment, Article $article=null,Comments $parentid):void{
        $comment->setActive(0)
                ->setArticle($article)
                ->setCreatedAt(new \DateTime('nom'));
        if ($parentid != null) {
            // on cherche le commentaire correspondant
            $repo = $manager->getRepository(Comments::class);
            $parent = $repo->find($parentid);
        }
        $comment->setParent($parent ?? null);
        $this->manager->persist($comment);
        $this->manager->flush();
        $this->flash->add('success','You comment has been already sent.Thank you.');
    }
}