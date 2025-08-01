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
            ->add('sort', ChoiceType::class, [
                'label' => 'Sort by',
                'required' => false,
                'choices' => [
                    'ID asc' => 'id:asc',
                    'ID desc' => 'id:desc',
                    'First Name asc' => 'first_name:asc',
                    'First Name desc' => 'first_name:desc',
                    'Last Name asc' => 'last_name:asc',
                    'Last Name desc' => 'last_name:desc',
                    'Gender asc' => 'gender:asc',
                    'Gender desc' => 'gender:desc',
                    'Birthdate asc' => 'birthdate:asc',
                    'Birthdate desc' => 'birthdate:desc',
                ],
                'placeholder' => '---',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
