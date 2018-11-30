<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Email cannot be left blank.'
                    ]),
                    new Assert\Email([
                        'message' => 'Email format is not valid.'
                    ])
                ],
                'required' => true
            ])
            ->add('username', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Username cannot be left blank.'
                    ]),
                    new Assert\Length([
                        'min' => 4,
                        'minMessage' => 'Username cannot be shorter than 4 characters.',
                        'max' => 20,
                        'maxMessage' => 'Username cannot be longer than 20 characters.'
                    ])
                ],
                'required' => true
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'first_options' => [
                    'label' => 'Password'
                ],
                'second_options' => [
                    'label' => 'Repeated password'
                ],
                'required' => true,
                'first_name' => 'first',
                'second_name' => 'second'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-darker'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
