<?php

namespace App\Controller\Admin;
use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
         return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Astronomy Website');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud(' Users', 'fa fa-users', \App\Entity\User::class);
        yield MenuItem::linkToCrud(' Posts', 'fa fa-newspaper', Article::class);
        yield MenuItem::linkToCrud(' Comments', 'fa fa-comments', \App\Entity\Comments::class);
        yield MenuItem::linkToCrud(' Merchandise', 'fa fa-product', \App\Entity\Merchandise::class);
        yield MenuItem::linkToCrud(' Orders', 'fa fa-credit-card', \App\Entity\Order::class);
        yield MenuItem::linkToCrud(' MerchandiseOrders', 'fa fa-orders', \App\Entity\MerchOrder::class);


    }
}
