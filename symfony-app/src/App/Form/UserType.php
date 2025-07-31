<?php

declare(strict_types=1);

namespace GMG\App\Form;

use GMG\ApiHandler\DTO\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'First Name',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => 50,
                        'maxMessage' => 'First name cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Last Name',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => 50,
                        'maxMessage' => 'Last name cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Gender',
                'choices' => [
                    '♂' => 'male',
                    '♀' => 'female',
                ],
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Birthdate',
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\LessThanOrEqual([
                        'value' => 'today',
                        'message' => 'The birthdate must be in the past.',
                    ]),
                    new Assert\GreaterThanOrEqual([
                        'value' => '1900-01-01',
                        'message' => 'The birthdate must be after {{ compared_value }}.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'empty_data' => function (FormInterface $form) {
                return new User(
                    0,
                    $form->get('firstname')->getData(),
                    $form->get('lastname')->getData(),
                    $form->get('gender')->getData(),
                    \DateTimeImmutable::createFromMutable($form->get('birthdate')->getData())
                );
            },
            'csrf_protection' => true,
        ]);
    }
}
