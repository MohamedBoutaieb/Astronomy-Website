<?php

namespace App\Controller\Admin;
use App\Controller\ArticleController;
use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use http\Client\Curl\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Astronomy Website')
            ->renderContentMaximized()
            ->renderSidebarMinimized()
            ->disableUrlSignatures();
        //->setTranslationDomain('admin');


    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        MenuItem::section('Blog');
            MenuItem::linkToCrud('Blog Posts', 'fa fa-file-text', Article::class);
        MenuItem::linkToCrud('Add Post', 'fa fa-tags', Article::class)
            ->setAction('new');
        MenuItem::linkToCrud('Show Main Post', 'fa fa-tags', Article::class)
            ->setAction('detail')
            ->setEntityId(1);
        MenuItem::linkToCrud('Articles', 'fa fa-tags', Article::class)
            ->setController(ArticleController::class);
        MenuItem::linkToCrud('Articles', 'fa fa-tags', Article::class)
            ->setDefaultSort(['createdAt' => 'DESC']);
            MenuItem::section('Users');
            MenuItem::linkToCrud('Users', 'fa fa-user', \App\Entity\User::class);
        MenuItem::linkToDashboard('Home', 'fa fa-home');
        yield MenuItem::linktoRoute('Stats', 'fa fa-chart-bar', 'shop');
        MenuItem::section('Blog');
        MenuItem::linkToLogout('Logout', 'fa fa-exit');
        MenuItem::linkToExitImpersonation('Stop impersonation', 'fa fa-exit');
        MenuItem::subMenu('Blog', 'fa fa-article')->setSubItems([
            MenuItem::linkToCrud('Posts', 'fa fa-file-text', Article::class),
        ]);}
        public function configureUserMenu( UserInterface $user):UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getUsername())
            ->displayUserName(false)
          //  ->setAvatarUrl($user->getProfileImageUrl())
            // use this method if you don't want to display the user image
            ->displayUserAvatar(false)
            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('My Profile', 'fa fa-id-card', 'profile'),
                MenuItem::section(),
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }

}
