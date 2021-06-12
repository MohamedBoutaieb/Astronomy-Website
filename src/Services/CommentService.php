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
    public function persistComment(Comments $comment, Article $article, Comments $parent = null):void{
        $comment->setActive(1)
                ->setArticle($article)
                ->setCreatedAt(new \DateTime('now'));
        $comment->setParent($parent);
        $this->manager->persist($comment);
        $this->manager->flush();
        $this->flash->add('success','Your comment has been published.Thank you!');
    }
}