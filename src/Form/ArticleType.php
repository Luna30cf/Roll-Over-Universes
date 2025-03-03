<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Categories;
use App\Entity\Themes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, [
                'label' => 'Nom de l\'article'
            ])
            ->add('Cover', TextType::class, [
                'label' => 'URL de l\'image de couverture',
                'required' => false
            ])
            ->add('Description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('Price', MoneyType::class, [
                'label' => 'Prix (€)',
                'currency' => 'EUR'
            ])
            ->add('Publication_date', DateType::class, [
                'label' => 'Date de publication',
                'widget' => 'single_text'
            ])
            ->add('Items_stored', IntegerType::class, [
                'label' => 'Stock disponible'
            ])
            ->add('Author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'username',
                'label' => 'Auteur'
            ])
            ->add('Category', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
                'label' => 'Catégorie'
            ])
            ->add('Theme', EntityType::class, [
                'class' => Themes::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Thèmes'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter l\'article'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
