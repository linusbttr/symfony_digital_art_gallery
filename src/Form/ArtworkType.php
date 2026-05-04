<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Artwork;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank(message: 'Title cannot be empty'),
                    new Length(max: 255),
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank(message: 'Description cannot be empty'),
                ]
            ])
            ->add('creationDate', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(message: 'Creation date cannot be empty'),
                ]
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Artwork Image',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                new File(
                    maxSize: '5M',
                    mimeTypes: ['image/jpeg', 'image/png'],
                    mimeTypesMessage: 'Please upload a valid image (jpg, png)',
                )
                ]
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank(message: 'Please select an artist'),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}