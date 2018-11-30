<?php

namespace AppBundle\Controller\User;

use AppBundle\Entity\User;
use AppBundle\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class PasswordController
 * @package AppBundle\Controller\CocktailManager\User
 */
class PasswordController extends Controller
{
    /**
     * @Route("/user/{id}/change-password", name="user_change_password", methods={"GET", "PATCH"}, requirements={"id"="\d+"})
     * @param int $id
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changeAction($id, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $checker = $this->get('security.authorization_checker');
        if (!$checker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('cm_login');
        }

        $user = ($id == $this->getUser()->getId()) ? $this->getUser() : null;

        if (!$user instanceof User) {
            return $this->render('@Twig/Exception/error.html.twig', [
                'msg' => 'error-general',
                'route' => 'cm_dashboard',
                'route_description' => 'Return to dashboard'
            ]);
        }

        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($request->isMethod('PATCH')) {
            if ($form->isSubmitted() and $form->isValid()) {
                $newPasswordEncoded = $encoder->encodePassword($user, $form['newPassword']->getData());
                $user->setPassword($newPasswordEncoded);

                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'You have successfully changed your password.');

                return $this->redirectToRoute('cm_dashboard');
            }
        }

        return $this->render('user/change_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}