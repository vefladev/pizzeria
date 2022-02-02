<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Pizzeria');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/style.css');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Produits', 'fa fa-pizza-slice'),
            MenuItem::linkToCrud('Catégories', 'fa fa-tags', Category::class),
            MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', Customer::class)
        ];

    }
}
