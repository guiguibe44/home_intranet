<?php

namespace App\Controller\Admin;

use App\Entity\Access;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AccessCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Access::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Accès')
            ->setEntityLabelInPlural('Accès')
            ->setPaginatorPageSize(100)
            ->setSearchFields(['service.name', 'website.name']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name','Nom'),
            TextareaField::new('description','Description'),
            TextField::new('CryptedLogin','Login')->hideOnIndex(),
            TextField::new('CryptedPassword','Mot de passe')->hideOnIndex(),
            AssociationField::new('service','Services')
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, 'detail');
    }


}
