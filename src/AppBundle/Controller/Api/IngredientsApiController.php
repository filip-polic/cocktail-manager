<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Ingredient;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IngredientsApiController
 * @Route("/api")
 * @package AppBundle\Controller\CocktailManager
 */
class IngredientsApiController extends Controller
{
    /**
     * @Route("/ingredients", name="ingredients_api_index", methods={"GET"})
     * @return Response
     */
    public function indexAction()
    {
        $ingredients = $this->getDoctrine()->getRepository(Ingredient::class)
            ->findBy([], [
                'name' => 'ASC'
            ]);

        $context = SerializationContext::create()
            ->enableMaxDepthChecks()->setGroups([
                'Default',
                'ingredient_show'
            ])
        ;

        $serialized = $this->get('jms_serializer')->serialize($ingredients, 'json', $context);
        return new Response($serialized, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/ingredient/{id}", name="ingredient_api_show", methods={"GET"}, requirements={"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function showAction($id)
    {
        $ingredient = $this->getDoctrine()->getRepository(Ingredient::class)->find($id);

        if (!$ingredient instanceof Ingredient) {
            return new Response(json_encode([
                'error' => 'Ingredient with an id of '.$id.' does not exist.'
            ]), 404, [
                'Content-Type' => 'application/json'
            ]);
        }

        $context = SerializationContext::create()
            ->enableMaxDepthChecks()->setGroups([
                'Default',
                'ingredient_show'
            ])
        ;

        $serialized = $this->get('jms_serializer')->serialize($ingredient, 'json', $context);
        return new Response($serialized, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
