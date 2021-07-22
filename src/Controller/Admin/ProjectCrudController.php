<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Projets')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer un nouveau projet')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails du projet')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier le projet');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter un projet');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Créer un projet');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Créer et ajouter un nouveau');
            })
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields =[];
        if ($pageName == Crud::PAGE_INDEX) {
            array_push(
                $fields,
                TextField::new('title', 'Titre'),
                ImageField::new('Illustration', 'Illustration'),
                TextField::new('github_link', 'lien GitHub'),
                TextField::new('website_link', 'Lien du site'),
                DateField::new('created_at', 'Créer le'),
            );
        }
        if ($pageName == Crud::PAGE_NEW || $pageName == Crud::PAGE_EDIT) {
            array_push(
                $fields,
                TextField::new('title', 'Titre'),
                TextField::new('pitch', ''),
                TextEditorField::new('description', ''),
                AssociationField::new('technos', 'Technologies'),
                DateField::new('created_at', 'Date du projet'),
                TextField::new('github_link', 'lien GitHub'),
                TextField::new('website_link', 'Lien du site'),
            );
        }

        return $fields;
    }
}
