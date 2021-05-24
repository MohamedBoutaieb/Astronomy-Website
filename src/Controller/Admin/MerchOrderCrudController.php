<?php

namespace App\Controller\Admin;

use App\Entity\MerchOrder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class MerchOrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MerchOrder::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            NumberField::new('quantity'),
            AssociationField::new('toOrder'),
            AssociationField::new('toMerch'),
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['quantity'=>'DESC']);
    }

}
