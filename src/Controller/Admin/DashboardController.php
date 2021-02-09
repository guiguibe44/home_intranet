<?php

namespace App\Controller\Admin;

use App\Entity\Access;
use App\Entity\Domain;
use App\Entity\Service;
use App\Entity\User;
use App\Entity\Website;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(WebsiteCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Home Intranet');
    }
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            //->setName($user->getFullName())
            // use this method if you don't want to display the name of the user
            ->displayUserName(true)

            // you can return an URL with the avatar image
            //->setAvatarUrl('https://...')
            //->setAvatarUrl($user->getProfileImageUrl())
            // use this method if you don't want to display the user image
            ->displayUserAvatar(true)
            // you can also pass an email address to use gravatar's service
            //->setGravatarEmail($user->getMainEmailAddress())

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                //MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
                //MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                //MenuItem::section(),
                //MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
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
