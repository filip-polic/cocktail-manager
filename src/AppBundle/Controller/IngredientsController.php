<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class IngredientsController
 * @package AppBundle\Controller\CocktailManager
 */
class IngredientsController extends Controller
{
    private $checker;

    public function __construct(AuthorizationCheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    /**
     * @Route("/ingredients", name="ingredients_index", methods={"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $ingredients = $this->getDoctrine()->getRepository(Ingredient::class)
            ->findBy([], [
                'name' => 'ASC'
            ]);
        return $this->render('ingredients/index.html.twig', [
            'ingredients' => $ingredients
        ]);
    }

    /**
     * @Route("/ingredient/{id}", name="ingredient_show", methods={"GET"}, requirements={"id"="\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id) {
        $ingredient = $this->getDoctrine()->getRepository(Ingredient::class)->find($id);
        return $this->render('ingredients/show.html.twig', [
            'ingredient' => $ingredient
        ]);
    }

    /**
     * @Route("/ingredient/create", name="ingredient_create", methods={"GET", "POST"})
     */
    public function createAction() {
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
    }

    /**
     * @Route("/ingredient/{id}/edit", name="ingredient_edit", methods={"GET", "PUT"}, requirements={"id"="\d+"})
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
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
    }

    /**
     * @Route("/ingredient/{id}", name="ingredient_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteAction($id) {
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

        return new Response('Deleting the ingredient with an id of '.$id);
    }
}
