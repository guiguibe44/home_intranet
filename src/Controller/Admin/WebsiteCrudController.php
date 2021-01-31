<?php

namespace App\Controller\Admin;

use App\Entity\Website;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WebsiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Website::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Site web')
            ->setEntityLabelInPlural('Sites web')
            ->setPaginatorPageSize(100);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('domain','Domaine'),
            TextField::new('ftpHost','Hôte FTP')->hideOnIndex(),
            TextField::new('ftpUser','Utilisateur FTP')->hideOnIndex(),
            TextField::new('CryptedFtpPassword','Mot de passe FTP')->hideOnIndex(),
            TextField::new('sqlAddress', 'Adresse SQL')->hideOnIndex(),
            TextField::new('sqlDataBaseName','Nom de la base SQL')->hideOnIndex(),
            TextField::new('sqlUser', 'Utilisateur SQL')->hideOnIndex(),
            TextField::new('CryptedSqlPassword','Mot de passe SQL')->hideOnIndex(),
            AssociationField::new('customer', 'Client'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, 'detail');
    }

}
