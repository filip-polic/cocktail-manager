<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldPassword', PasswordType::class, [
            'constraints' => [
                new SecurityAssert\UserPassword([
                    'message' => 'This value should be the user\'s current password.'
                ]),
                new Assert\NotBlank([
                    'message' => 'Password cannot be left blank.'
                ])
            ],
            'mapped' => false,
            'required' => true,
            'label' => 'current-password',
        ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Passwords do not match.',
                'required' => true,
                'first_options'  => array('label' => 'New password'),
                'second_options' => array('label' => 'Repeat new password'),
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Password cannot be left blank.'
                    ]),
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'Password has to be longer than 8 characters.'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [ 'label' => 'Save changes', 'attr' => [ 'class' => 'btn btn-darker rounded-0' ] ]);
        $builder->setMethod('PATCH');
    }
}
