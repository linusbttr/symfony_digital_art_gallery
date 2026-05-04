<?php

namespace App\Form;

use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(message: 'Name cannot be empty'),
                    new Length(max: 255),
                ]
            ])
            ->add('biography', TextareaType::class, [
                'constraints' => [
                    new NotBlank(message: 'Biography cannot be empty'),
                ]
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(message: 'Birth date cannot be empty'),
                ]
            ])
            ->add('nationality', TextType::class, [
                'constraints' => [
                    new NotBlank(message: 'Nationality cannot be empty'),
                    new Length(max: 255),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}