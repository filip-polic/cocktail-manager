<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cocktail;
use AppBundle\Entity\Ingredient;
use AppBundle\Form\CocktailType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class CocktailsController
 * @package AppBundle\Controller\CocktailManager
 */
class CocktailsController extends Controller
{
    private $checker;

    public function __construct(AuthorizationCheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    /**
     * @Route("/cocktails", name="cocktails_index", methods={"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $cocktails = null;
        if ($this->getUser()) {
            $cocktails = $this->getDoctrine()->getRepository(Cocktail::class)
                ->findBy([], [
                    'user' => 'DESC',
                    'name' => 'ASC'
                ]);
        } else {
            $cocktails = $this->getDoctrine()->getRepository(Cocktail::class)
                ->findBy([], [
                    'name' => 'ASC'
                ]);
        }
        $deleteForm = $this->createFormBuilder()
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-sm btn-danger flex-center'
                ],
                'label' => 'Delete'
            ])->getForm();

        return $this->render('cocktails/index.html.twig', [
            'cocktails' => $cocktails,
            'deleteForm' => $deleteForm->createView()

        ]);
    }

    /**
     * @Route("/cocktail/{id}", name="cocktail_show", methods={"GET"}, requirements={"id"="\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id) {
        $cocktail = $this->getDoctrine()->getRepository(Cocktail::class)->find($id);
        return $this->render('cocktails/show.html.twig', [
            'cocktail' => $cocktail,
        ]);
    }

    /**
     * @Route("/cocktail/create", name="cocktail_create", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request) {
        if (!$this->checker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('cm_login');
        }

        if (!$this->checker->isGranted('ROLE_USER')) {
            return $this->render('@Twig/Exception/error.html.twig', [
                'msg' => 'You don\'t have the permission to do that, mister!',
                'route' => 'cm_dashboard',
                'route_description' => 'Return to dashboard'
            ]);
        }

        $cocktail = new Cocktail();
        $form = $this->createForm(CocktailType::class, $cocktail,[
            'method' => 'POST'
        ]);
        $form->handleRequest($request);
        $allIngredients = $this->getDoctrine()->getRepository(Ingredient::class)->findBy([], [
            'name' => 'ASC'
        ]);

        $context = SerializationContext::create()
            ->enableMaxDepthChecks()->setGroups([
                'Default'
            ])
        ;

        $serialized = $this->get('jms_serializer')->serialize($allIngredients, 'json', $context);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() and $form->isValid()) {

                $cocktailName = $form['name']->getData();
                $description = $form['description']->getData();
                $preparation = $form['preparation']->getData();

                $difficulty = $form['difficulty']->getData();
                if (!in_array(strtolower($difficulty), [ 'easy', 'medium', 'hard' ])) {
                    $form->get('difficulty')->addError(new FormError('Difficulty format is not valid.'));
                }

                if (isset($request->request->get('cocktail')['ingredients'])) {
                    foreach ($request->request->get('cocktail')['ingredients'] as $id) {
                        foreach ($allIngredients as $ingredient) {
                            if ($id == $ingredient->getId()) {
                                $cocktail->addIngredient($ingredient);
                            }
                        }
                    }
                }

                if (isset($request->request->get('cocktail')['new_ingredients'])) {
                    foreach ($request->request->get('cocktail')['new_ingredients'] as $new_ingredient) {
                        $ingredient = new Ingredient();
                        $ingredient->setName($new_ingredient);
                        $this->getDoctrine()->getManager()->persist($ingredient);
                        $cocktail->addIngredient($ingredient);
                    }
                }

                $cocktail
                    ->setName($cocktailName)
                    ->setDescription($description)
                    ->setPreparation($preparation)
                    ->setDifficulty($difficulty)
                    ->setUser($this->getUser());

                $this->getDoctrine()->getManager()->persist($cocktail);

                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'You have successfully created a cocktail. Well done!');

                return $this->redirectToRoute('cm_dashboard');
            }
        }

        return $this->render('cocktails/create.html.twig', [
            'form' => $form->createView(),
            'ingredients' => $serialized
        ]);
    }

    /**
     * @Route("/cocktail/{id}/edit", name="cocktail_edit", methods={"GET", "PUT", "POST"}, requirements={"id"="\d+"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response|JsonResponse
     */
    public function editAction(Request $request, $id) {
        if (!$this->checker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('cm_login');
        }

        if (!$this->checker->isGranted('ROLE_USER')) {
            return $this->render('@Twig/Exception/error.html.twig', [
                'msg' => 'You don\'t have the permission to do that, mister!',
                'route' => 'cm_dashboard',
                'route_description' => 'Return to dashboard'
            ]);
        }

        $cocktail = $this->getDoctrine()->getRepository(Cocktail::class)->find($id);

        if (!$cocktail instanceof Cocktail) {
            return $this->render('@Twig/Exception/error.html.twig', [
                'msg' => 'There was an error while transferring data.',
                'route' => 'cm_dashboard',
                'route_description' => 'Return to dashboard'
            ]);
        }

        if (!$this->checker->isGranted('ROLE_ADMIN') and
            null == $cocktail->getUser()) {
            return $this->render('@Twig/Exception/error.html.twig', [
                'msg' => 'You don\'t have the permission to do that, mister!',
                'route' => 'cm_dashboard',
                'route_description' => 'Return to dashboard'
            ]);
        }

        $form = $this->createForm(CocktailType::class, $cocktail, [
            'method' => 'PUT'
        ]);
        $form->handleRequest($request);
        $allIngredients = $this->getDoctrine()->getRepository(Ingredient::class)->findBy([], [
            'name' => 'ASC'
        ]);
        $context = SerializationContext::create()
            ->enableMaxDepthChecks()->setGroups([
                'Default'
            ])
        ;
        $serialized = $this->get('jms_serializer')->serialize($allIngredients, 'json', $context);


        if ($form->isSubmitted() and $form->isValid()) {
            $cocktailName = $form['name']->getData();
            $description = $form['description']->getData();
            $preparation = $form['preparation']->getData();

            $difficulty = $form['difficulty']->getData();
            if (!in_array(strtolower($difficulty), [ 'easy', 'medium', 'hard' ])) {
                $form->get('difficulty')->addError(new FormError('Difficulty format is not valid.'));
            }

            $cocktail->getIngredients()->clear();

            if (isset($request->request->get('cocktail')['ingredients'])) {
                foreach ($request->request->get('cocktail')['ingredients'] as $id) {
                    foreach ($allIngredients as $ingredient) {
                        if ($id == $ingredient->getId()) {
                            $cocktail->addIngredient($ingredient);
                        }
                    }
                }
            }

            if (isset($request->request->get('cocktail')['new_ingredients'])) {
                foreach ($request->request->get('cocktail')['new_ingredients'] as $new_ingredient) {
                    $ingredient = new Ingredient();
                    $ingredient->setName($new_ingredient);
                    $this->getDoctrine()->getManager()->persist($ingredient);
                    $cocktail->addIngredient($ingredient);
                }
            }

            $cocktail
                ->setName($cocktailName)
                ->setDescription($description)
                ->setPreparation($preparation)
                ->setDifficulty($difficulty)
                ->setUser($this->getUser());

            $this->getDoctrine()->getManager()->persist($cocktail);

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'You have successfully updated a cocktail.');

            return $this->redirectToRoute('cocktail_show', [
                'id' => $cocktail->getId()
            ]);
        }

        return $this->render('cocktails/edit.html.twig', [
            'cocktail' => $cocktail,
            'form' => $form->createView(),
            'ingredients' => $serialized
        ]);
    }

    /**
     * @Route("/cocktail/{id}", name="cocktail_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, $id) {
        if (!$this->checker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('cm_login');
        }

        if (!$this->checker->isGranted('ROLE_USER')) {
            return $this->render('@Twig/Exception/error.html.twig', [
                'msg' => 'You don\'t have the permission to do that, mister!',
                'route' => 'cm_dashboard',
                'route_description' => 'Return to dashboard'
            ]);
        }

        if ($request->request->has('_cocktail_delete_token_'.$id)) {
            $token = $request->request->get('_cocktail_delete_token_'.$id);
            if (!$this->isCsrfTokenValid('_cocktail_delete_token_'.$id, $token)) {
                $this->addFlash('error', 'Invalid CSRF token.');

                return $this->redirect($request->headers->get('referer'));
            }
        }

        $cocktail = $this->getDoctrine()->getRepository(Cocktail::class)->find($id);

        if (!$cocktail or !$cocktail instanceof Cocktail) {
            $this->addFlash('error', 'There was an error while deleting the cocktail. Please refresh the page and try again.');

            return $this->redirectToRoute('cm_dashboard');
        }

        $this->getDoctrine()->getManager()->remove($cocktail);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', '"'.$cocktail->getName().'" was successfully deleted from the database.');

        return $this->redirect($request->headers->get('referer'));
    }
}