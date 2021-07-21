<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Entity\Contact;
use App\Entity\Project;
use App\Entity\Techno;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(ProjectCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Joulia Guillaume');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Retour sur le site', 'fa fa-home', 'home');
        yield MenuItem::linkToRoute('Déconnexion', 'fa fa-sign-out', 'app_logout');
        yield MenuItem::section('Menu');
        yield MenuItem::linkToCrud('Projets', '', Project::class);
        yield MenuItem::linkToCrud('A propos', '', About::class);
        yield MenuItem::linkToCrud('Technos', '', Techno::class);
        yield MenuItem::linkToCrud('Contact', '', Contact::class);
    }
}
