<?php

namespace App\Controller;

use App\Factories\UserFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * -note: this controller was created to group every authentication routes
 * @Route(name="auth_form_")
 */
class AuthController extends AbstractController
{
    /**
     * Login form
     * @Route("/login", name="login")
     * @param \Symfony\Component\Security\Http\Authentication\AuthenticationUtils $authenticationUtils
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils) : Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('user_admin');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * Logout Action
     * @Route("/logout", name="logout")
     */
    public function logout() : RedirectResponse {
        return $this->redirectToRoute('auth_form_login');
    }

    /**
     * -note: there is a separation between the render and the action functions because
     *       it's better to keep separate domains and responsibilities
     * Form to register new user.
     * @Route("/register", name="register_render", methods={"GET"})
     *
     * @param \Symfony\Component\HttpFoundation\Request                             $request
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register_render(Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response {

        if ($this->getUser()) {
            return $this->redirectToRoute('user_admin');
        }

        return $this->render('security/register.html.twig', [
            'last_username' => '',
            'error'         => '',
        ]);
    }

    /**
     * Register action
     * @Route("/register", name="register", methods={"POST"})
     * @param \Symfony\Component\HttpFoundation\Request                             $request
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response {
        $formData = $request->request;

        if ($formData->get('inputPassword') !== $formData->get('repeatPassword')) {
            return $this->render('security/register.html.twig', [
                'last_username' => '',
                'error'         => "Passwords don't match!",
            ]);
        }

        $user = (new UserFactory([
                                     'username' => $formData->get('username'),
                                     'password' => $formData->get('inputPassword'),
                                 ]))->setPasswordEncoder($passwordEncoder)->make();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('user_admin');
    }

}
