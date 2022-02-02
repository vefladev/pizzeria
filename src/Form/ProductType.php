<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
        'label' => 'Nom',
        'required' => true,
    ])
            ->add('description', CKEditorType::class, array(
                'label' => 'Description',
                'required' => true,
            ))
            /*->add('description',TextareaType::class, [
        'label' => 'Description',
        'required' => true,
    ])*/
            ->add('price', null, [
                'label' => 'Prix',
                'required' => true,
            ])
            ->add('image', FileType::class, [
        'mapped' => false,
        'constraints' => [
            new File([
                'maxSize' => '10240k',
                'mimeTypes' => [
                    'image/*'
                ],
                'mimeTypesMessage' => 'Le format est incorrect.',
            ])
        ],
    ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégorie',
                'choice_value' => 'id',
                'choice_label' => 'name',
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
