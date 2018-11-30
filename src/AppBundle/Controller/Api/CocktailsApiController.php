<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Cocktail;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CocktailsApiController
 * @Route("/api")
 * @package AppBundle\Controller\CocktailManager
 */
class CocktailsApiController extends Controller
{
    /**
     * @Route("/cocktails", name="cocktails_api_index", methods={"GET"})
     * @return Response
     */
    public function indexAction()
    {
        $cocktails = $this->getDoctrine()->getRepository(Cocktail::class)
            ->findBy([], [
                'name' => 'ASC'
            ]);

        $context = SerializationContext::create()
            ->enableMaxDepthChecks()->setGroups([
                'Default',
                'cocktail_show'
            ])
        ;

        $serialized = $this->get('jms_serializer')->serialize($cocktails, 'json', $context);
        return new Response($serialized, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/cocktail/{id}", name="cocktail_api_show", methods={"GET"}, requirements={"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function showAction($id)
    {
        $cocktail = $this->getDoctrine()->getRepository(Cocktail::class)->find($id);

        if (!$cocktail instanceof Cocktail) {
            return new Response(json_encode([
                'error' => 'Cocktail with an id of '.$id.' does not exist.'
            ]), 404, [
                'Content-Type' => 'application/json'
            ]);
        }

        $context = SerializationContext::create()
            ->enableMaxDepthChecks()->setGroups([
                'Default',
                'cocktail_show'
            ])
        ;

        $serialized = $this->get('jms_serializer')->serialize($cocktail, 'json', $context);
        return new Response($serialized, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
