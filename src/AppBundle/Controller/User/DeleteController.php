<?php

namespace AppBundle\Controller\User;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends Controller
{
    /**
     * @Route("/user/{id}", name="user_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, $id)
    {
        $checker = $this->get('security.authorization_checker');
        if (!$checker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('cm_login');
        }

        if (!$checker->isGranted('ROLE_USER') or ($id !== $this->getUser()->getId())) {
            return $this->render('@Twig/Exception/error.html.twig', [
                'msg' => 'You don\'t have the permission to do that, mister!',
                'route' => 'cm_dashboard',
                'route_description' => 'Return to dashboard'
            ]);
        }

        if ($request->request->has('_user_delete_token_'.$id)) {
            $token = $request->request->get('_user_delete_token_'.$id);
            if (!$this->isCsrfTokenValid('_user_delete_token_'.$id, $token)) {
                $this->addFlash('error', 'Invalid CSRF token.');

                return $this->redirect($request->headers->get('referer'));
            }
        }

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if (!$user or !$user instanceof User) {
            $this->addFlash('error', 'There was an error while deleting your account. Please refresh the page and try again.');

            return $this->redirectToRoute('cm_dashboard');
        }

        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'Your account was successfully deleted from the database.');

        return $this->redirectToRoute('cm_login');
    }
}
