<?php

namespace AppBundle\Form;

use AppBundle\Entity\Cocktail;
use AppBundle\Entity\Ingredient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CocktailType extends AbstractType
{
    private $ingredients;

    public function __construct(ContainerInterface $container)
    {
        $this->ingredients = $container->get('doctrine')->getRepository(Ingredient::class)->findBy([], [ 'name' => 'ASC' ]);
    }

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
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Description cannot be left blank.'
                    ]),
                    new Assert\Length([
                        'max' => 640,
                        'maxMessage' => 'Description cannot be longer than 640 characters.'
                    ])
                ],
                'attr' => [
                    'class' => 'p-4 form-control rounded-0'
                ]
            ])
            ->add('preparation', TextareaType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Preparation cannot be left blank.'
                    ]),
                    new Assert\Length([
                        'max' => 1024,
                        'maxMessage' => 'Preparation cannot be longer than 1024 characters.'
                    ])
                ],
                'attr' => [
                    'class' => 'p-4 form-control rounded-0'
                ]
            ])
            ->add('difficulty', ChoiceType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Difficulty cannot be left blank.'
                    ]),
                    new Assert\Length([
                        'max' => 1024,
                        'maxMessage' => 'Difficulty cannot be longer than 32 characters.'
                    ])
                ],
                'choices' => [
                    'Easy' => 'Easy',
                    'Medium' => 'Medium',
                    'Hard' => 'Hard'
                ],
                'placeholder' => '-- Choose a difficulty',
                'attr' => [
                    'class' => 'form-control rounded-0'
                ]
            ])
            ->add('ingredients', EntityType::class, [
                'mapped' => false,
                'class' => Ingredient::class,
                'data' => null,
                'required' => false,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control rounded-0'
                ],
                'multiple' => true,
                'placeholder' => '-- Choose an ingredient'
            ])
            ->add('new_ingredients', TextType::class, [
                'mapped' => false,
                'data' => null,
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-darker rounded-0'
                ]
            ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, [
            $this, 'onPreSubmit'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cocktail::class
        ]);
    }

    public function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();

        if (!isset($_POST['cocktail']['ingredients']) and !isset($_POST['cocktail']['new_ingredients'])) {
            $form->addError(new FormError('You have to either select an existing or add a new ingredient.'));
        }

        if (isset($_POST['cocktail']['new_ingredients'])) {
            foreach ($_POST['cocktail']['new_ingredients'] as $new_ingredient) {
                $name = filter_var($new_ingredient, FILTER_SANITIZE_SPECIAL_CHARS);

                foreach ($this->ingredients as $ingredient) {
                    if (strtolower($ingredient->getName()) == strtolower($name)) {
                        $form->addError(new FormError('Ingredient with the name "'.$ingredient->getName().'" already exists.'));
                    }
                }
            }
        }
    }
}
