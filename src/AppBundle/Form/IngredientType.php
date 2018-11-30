<?php

namespace AppBundle\Form;

use AppBundle\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Name cannot be left blank.'
                    ]),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'Name cannot be longer than 255 characters.'
                    ])
                ],
                'attr' => [
                    'class' => 'p-4 form-control rounded-0'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class
        ]);
    }
}
