<?php

namespace AppBundle\Controller\User;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AuthenticationController
 * @package AppBundle\Controller\CocktailManager
 */
class AuthenticationController extends Controller
{
    /**
     * @Route("/register", name="cm_register", methods={"GET", "POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $checker = $this->get('security.authorization_checker');
        if ($checker->isGranted('IS_AUTHENTICATED_FULLY') and $checker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('cm_dashboard');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $email = filter_var(filter_var($form['email']->getData(), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
            if (!$email) {
                $form->get('email')->addError(new FormError('Email format is not valid.'));
            }

            $username = filter_var($form['username']->getData(), FILTER_SANITIZE_SPECIAL_CHARS);
            if (!$username) {
                $form->get('username')->addError(new FormError('Username field did not pass the validation.'));
            }

            $password = $encoder->encodePassword($user, $form['password']->getData());

            $user
                ->setEmail($email)
                ->setUsername($username)
                ->setPassword($password)
                ->setDateJoined(new \DateTime());

            $token = new UsernamePasswordToken($user, null, 'cocktail_manager_area', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('cocktail_manager_area', serialize($token));

            $user->setLastLogin(new \DateTime());

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'You have successfully registered your account and were automatically logged in.');

            return $this->redirectToRoute('cm_dashboard');
        }

        return $this->render('auth/cm_register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="cm_login", methods={"GET", "POST"})
     *
     * @param AuthenticationUtils $utils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(AuthenticationUtils $utils)
    {
        $checker = $this->get('security.authorization_checker');
        if ($checker->isGranted('IS_AUTHENTICATED_FULLY') and $checker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('cm_dashboard');
        }

        return $this->render('auth/cm_login.html.twig', [
            'error' => $utils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="cm_logout")
     */
    public function logoutAction()
    {
    }
}
