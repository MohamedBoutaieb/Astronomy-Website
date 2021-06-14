<?php

namespace App\Controller\Admin;

use App\Entity\Comments;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Faker\Provider\Text;
use Faker\Test\Provider\TestableBarcode;
use phpDocumentor\Reflection\Types\Null_;

class CommentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comments::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            NumberField::new('id')->hideOnForm(),
            AssociationField::new('article'),
            DateField::new('createdAt')->hideOnForm(),
            NumberField::new('active'),
            AssociationField::new('parent'),
            TextField::new('pseudo'),
            EmailField::new('email')->onlyOnForms(),
            TextField::new('content'),
        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable( Action::NEW,Action::EDIT);}
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['created_at'=>'DESC']);
    }

}
