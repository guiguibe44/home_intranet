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
            TextField::new('ftpHost'),
            TextField::new('ftpUser'),
            TextField::new('ftpPassword'),
            TextField::new('sqlAddress'),
            TextField::new('sqlDataBaseName'),
            TextField::new('sqlUser'),
            TextField::new('sqlPassword'),
            AssociationField::new('customer'),
        ];
    }

}
