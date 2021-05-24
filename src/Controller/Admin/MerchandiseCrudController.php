<?php

namespace App\Controller\Admin;

use App\Entity\Merchandise;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MerchandiseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Merchandise::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('label'),
            TextField::new('type'),
            TextField::new('url'),
            NumberField::new('price')->hideOnIndex(),
            NumberField::new('inStock'),
            TextField::new('available'),
            AssociationField::new('merchOrders')
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['price'=>'DESC']);
    }

}
