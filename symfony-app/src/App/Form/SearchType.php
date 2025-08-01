<?php

declare(strict_types=1);

namespace GMG\App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', TextType::class, [
                'label' => 'Search',
                'required' => false,

            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Gender',
                'required' => false,
                'choices' => [
                    '♂' => 'male',
                    '♀' => 'female',
                ],
                'placeholder' => '---',
            ])

            ->add(
                'birthdate_from',
                DateType::class,
                [
                    'label' => 'Birthdate from',
                    'required' => false,
                    'widget' => 'single_text',
                ]
            )

            ->add(
                'birthdate_to',
                DateType::class,
                [
                    'label' => 'Birthdate to',
                    'required' => false,
                    'widget' => 'single_text',
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
