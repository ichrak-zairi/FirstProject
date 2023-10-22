<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Author;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\Mapping\Entity;
use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('title')
            ->add('category',ChoiceType::class,[
                'choices' => [
                    'science-fiction'=>'science-fiction',
                    'mystery'=>'mystery',
                    'autobiography'=> 'autobiography'

                ],
            ])
            ->add('author',EntityType::class,[
                'class'=>'use App\Entity\Author',
                'choice_label'=>'username',
                'multiple'=>false,
                'expanded' =>false,
                'required' => true,
                'placeholder' =>'choisir un auteur',
            ])
            ->add('published')
            ->add('publicationDate')
            ->add('author', EntityType::class, [
                'class' => Author::class, 
                'choice_label' => 'username', 
                'multiple'=>false,
                'expanded'=>false,
                'required'=> true,
                'placeholder'=>'choisir un auteur',
            ])


            ->add('save',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
    
}