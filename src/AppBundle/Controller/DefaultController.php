<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cocktail;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="cm_dashboard")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted(('IS_AUTHENTICATED_FULLY')) and
            $this->get('security.authorization_checker')->isGranted(('ROLE_USER'))) {

            $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser()->getId());
            if (!$user or !$user instanceof User) {
                $this->get('security.token_storage')->setToken(null);
                $this->get('session')->invalidate();
                return $this->render('@Twig/Exception/error.html.twig', [
                    'msg' => 'error-general',
                    'route' => 'cm_login',
                    'route_description' => 'Return to login'
                ]);
            }
            $cocktails = $this->getDoctrine()->getRepository(Cocktail::class)
                ->findBy([
                    'user' => $user->getId()
                ]);
            $deleteForm = $this->createFormBuilder()
                ->setMethod('DELETE')
                ->add('submit', SubmitType::class, [
                    'attr' => [
                        'class' => 'btn btn-sm btn-danger flex-center'
                    ],
                    'label' => 'Delete'
                ])->getForm();

            return $this->render('default/cm_dashboard.html.twig', [
                'cocktails' => $cocktails,
                'deleteForm' => $deleteForm->createView()
            ]);
        }
        return $this->render('default/cm_dashboard.html.twig', [

        ]);
    }
}
