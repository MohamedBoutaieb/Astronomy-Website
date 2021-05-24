<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class ,['label'=>'Your Email','attr'=>['class'=>'form-control']])
            ->add('pseudo',\Symfony\Component\Form\Extension\Core\Type\TextType::class ,['label'=>'Your nickname','attr'=>['class'=>'form-control']])
            ->add('content',\Symfony\Component\Form\Extension\Core\Type\HiddenType::class ,['label'=>'Your comment','attr'=>['class'=>'form-control']])
            ->add('parent', HiddenType::class,['mapped'=>false])
            ->add('Share_Comment',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
