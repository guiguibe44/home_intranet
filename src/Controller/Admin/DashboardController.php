<?php

namespace App\Controller\Admin;

use App\Entity\Access;
use App\Entity\Domain;
use App\Entity\Service;
use App\Entity\User;
use App\Entity\Website;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
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
            ->setTitle('Home Intranet');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Sites', 'fas fa-globe', Website::class);
        yield MenuItem::linkToCrud('Noms de domaine', 'fa fa-dot-circle', Domain::class);
        yield MenuItem::linkToCrud('Services', 'far fa-folder-open', Service::class);
        yield MenuItem::linkToCrud('Accès', 'fas fa-key', Access::class);
    }
}
