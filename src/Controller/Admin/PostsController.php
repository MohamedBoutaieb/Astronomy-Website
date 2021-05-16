<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/posts",name="admin_posts")
 * @package App\Controller\Admin
 */
class PostsController extends AbstractController
{
    /**
     * @Route("/",name="_home")
     */

    public function index (EntityManagerInterface $manager)
    {  $repository = $manager->getRepository(Article::class);
        $posts=$repository->findAll();
        return $this->render('admin/Posts/index.html.twig', [
            'posts' => $posts
        ]);
    }
    /**
     * @Route("/activate/{post}",name="_activate_post")
     */

    public function activate (EntityManagerInterface $manager , Article $post ){
        $post->setActive(($post->getActive())?false:true);
        $manager->persist($post);
        $manager->flush();
       return new Response("true");
    }
    /**
     * @Route("/Edit/{post}",name="_edit_post")
     */

    public function Edit(Article $post = null, EntityManagerInterface $manager)
    {

        if ($post) {
            $manager->remove($post);
            $manager->flush();
            $this->addFlash('success', "The post has been successfully deleted");
        } else {
            $this->addFlash('error', "The post does not exist");
        }

        return $this->redirectToRoute('admin_posts_home');
    }

    /**
     * @Route("/delete/{post}",name="_delete_post")
     */
    public function delete(Article $post = null, EntityManagerInterface $manager)
    {

        if ($post) {
            $manager->remove($post);
            $manager->flush();
            $this->addFlash('success', "The post has been successfully deleted");
        } else {
            $this->addFlash('error', "The post does not exist");
        }

        return $this->redirectToRoute('admin_posts_home');
    }


}
