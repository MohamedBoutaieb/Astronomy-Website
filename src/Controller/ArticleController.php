<?php
namespace App\Controller;
use App\Entity\Article;
use App\Entity\User;
use App\Form\EditPofileType;
use App\Form\PostsType;
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
    public function index(Request $request,EntityManagerInterface $manager,SessionInterface $session, $page, $number)
    {
        $post = new Article();
        $user = $session->get("username");
        $repository = $manager->getRepository(User::class);
        $user = $repository->findOneByUsername($user);
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isvalid()) {
            if($user) {
                $post->setUser($user)
                    ->SetActive(false)
                    ->SetCreatedAt();
                $manager->persist($post);
                $manager->flush();
                return $this->redirectToRoute('articles.list');
            }
            elseif (!$user){
                $this->addFlash("error", "You should login so that you can share an article.");
                return $this->redirectToRoute('login');
            }
        }

        $repository = $this->getDoctrine()->getRepository('App:Article');
        $articles = $repository->findBy(["active" => "true"], ["createdAt" => "DESC"],$number, ($page - 1) * $number);
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'form' => $form->createView()
        ]);
    }

}
