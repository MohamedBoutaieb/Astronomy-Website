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
                $this->addFlash("error", "You must login to share an article.");
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
            if ($user) {
                if ($commentForm->isSubmitted() && $commentForm->isvalid()) {

                     $comment->setUser($user);
                     $comment = $commentForm->getData();
                     //on récupère le contenu du champ parent
                     $parentId = $commentForm->get("parent")->getData();
                     $commentService->persistComment($comment, $article, $parentId);
                     return $this->redirectToRoute('Show_Article', ['article' => $article->getId()]);
                }
            } else {
                return $this->redirectToRoute('app_login');
            }
        $pseudo = $user->getUsername();
        return $this->render('article/show_article.html.twig', [
            'form' => $commentForm->createView(), 'article' => $article, 'comments' => $comments, 'pseudo' => $pseudo]);
    }


    /**
     * @Route("/add_reply/{comment}", name="show_replies")
     */
    public function addReply(Request $request, CommentService $commentService, Comments $comment, CommentsRepository $commentsRepository)
    {
//            $replies = $commentsRepository->findBy(['parent' => $comment->getId()]);

        $reply = new Comments();
        $user = $this->getUser();
        $replyForm = $this->createForm(ReplyType::class, $reply);
        $replyForm->handleRequest($request);
        if ($user) {
            if ($replyForm->isSubmitted() && $replyForm->isvalid()) {
                $reply->setUser($user);
                $reply = $replyForm->getData();
                $commentService->persistComment($reply, $comment->getArticle(), $comment);
                $comment = $comment->addReply($reply);

                return $this->redirectToRoute('show_replies', ['comment' => $comment->getId()]);

            }
        } else {
            return $this->redirectToRoute('app_login');
        }
        $replies = $comment->getReplies();
        $pseudo = $user->getUsername();
        return $this->render('comments/Replies.html.twig', [
            'form' => $replyForm->createView(), 'comment' => $comment, 'replies' => $replies, 'pseudo' => $pseudo]);
    }

}

