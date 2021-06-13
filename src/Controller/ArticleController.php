<?php
namespace App\Controller;
use App\Entity\Article;
use App\Entity\Comments;
use App\Entity\User;
use App\Form\CommentsType;
use App\Form\EditPofileType;
use App\Form\PostsType;
use App\Form\ReplyType;
use App\Repository\CommentsRepository;
use App\Services\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
class ArticleController extends AbstractController
{
    /**
     * @Route("/list/{page<\d+>?1}/{number<\d+>?6}", name="articles.list")
     */
    public function index(Request $request, EntityManagerInterface $manager, SessionInterface $session, $page, $number)
    {
        $post = new Article();
        $user = $this->getUser();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isvalid()) {
            if ($user) {
                $post->setUser($user)
                    ->SetActive(false)
                    ->SetCreatedAt();
                $manager->persist($post);
                $manager->flush();
                return $this->redirectToRoute('articles.list');
            } else {
                $this->addFlash("error", "You should login so that you can share an article.");
                return $this->redirectToRoute('app_login');
            }
        }


        $repository = $this->getDoctrine()->getRepository('App:Article');
        $articles = $repository->findBy(["active" => "1"], ["createdAt" => "DESC"], $number, ($page - 1) * $number);
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add_comment/{article}", name="Show_Article")
     */
    public function showDetails(Request $request, CommentService $commentService, Article $article, CommentsRepository $commentsRepository)
    {
        $comments = $commentsRepository->findBy(['article' => $article->getId()]);
        //on crée le commentaire
        $comment = new Comments();
        $user = $this->getUser();
        //on gère le formulaire
        $commentForm = $this->createForm(CommentsType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isvalid()) {
            if ($user) {
                $comment->setUser($user);
                $comment = $commentForm->getData();
                //on récupère le contenu du champ parent
                $parentId = $commentForm->get("parent")->getData();
                $commentService->persistComment($comment, $article, $parentId);
                return $this->redirectToRoute('Show_Article', ['article' => $article->getId()]);
            } else {
                return $this->redirectToRoute('app_login');
            }
        }
        return $this->render('article/show_article.html.twig', [
            'form' => $commentForm->createView(), 'article' => $article, 'comments' => $comments,]);
    }

    /**
     * @Route("/show_replies/{comment}", name="show_replies")
     */
    public function showReplies(CommentsRepository $commentsRepository, Comments $comment)
    {
        $replies = $commentsRepository->findBy(['parent' => $comment->getId()]);
        return $this->render('comments/Replies.html.twig', [
            'replies' => $replies,]);
    }

    /**
     * @Route("/add_reply/{comment}", name="add_reply")
     */
    public function addReply(CommentService $commentService, Comments $comment, Request $request, CommentsRepository $commentsRepository)
    {
        $reply = new Comments();
        $user = $this->getUser();
        $replyForm = $this->createForm(ReplyType::class, $reply);
        $replyForm->handleRequest($request);
        if ($replyForm->isSubmitted() && $replyForm->isvalid()) {
            if ($user) {
                $reply->setUser($user);
                $reply = $replyForm->getData();
                $commentService->persistComment($reply, $comment->getArticle(), $comment);
                return $this->redirectToRoute('add_reply', ['comment' => $comment->getId()]);
            } else {
                return $this->redirectToRoute('app_login');
            }
        }
    }

}

