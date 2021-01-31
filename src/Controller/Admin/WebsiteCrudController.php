<?php

namespace App\Controller\Admin;

use App\Entity\Website;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WebsiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Website::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('domain'),
            TextField::new('ftpHost')->hideOnIndex(),
            TextField::new('ftpUser')->hideOnIndex(),
            TextField::new('CryptedFtpPassword')->hideOnIndex(),
            TextField::new('sqlAddress')->hideOnIndex(),
            TextField::new('sqlDataBaseName')->hideOnIndex(),
            TextField::new('sqlUser')->hideOnIndex(),
            TextField::new('CryptedSqlPassword')->hideOnIndex(),
            AssociationField::new('customer'),
        ];
    }

}
