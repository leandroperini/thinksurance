<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route(name="auth_form_")
 */
class AuthController extends AbstractController
{
    /**
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
     * @Route("/logout", name="logout")
     */
    public function logout() : RedirectResponse {
        return $this->redirectToRoute('auth_form_login');
    }

    /**
     * @Route("/register", name="register_render", methods={"GET"})
     * @param \Symfony\Component\Security\Http\Authentication\AuthenticationUtils $authenticationUtils
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
     * @Route("/register", name="register", methods={"POST"})
     * @param \Symfony\Component\HttpFoundation\Request                             $request
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response {
        $user     = new User();
        $formData = $request->request;
        // encode the plain password
        if ($formData->get('inputPassword') !== $formData->get('repeatPassword')) {
            return $this->render('security/register.html.twig', [
                'last_username' => '',
                'error'         => "Passwords don't match!",
            ]);
        }
        $user->setUsername($formData->get('username'));
        $user->setRoles($user->getRoles());
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $formData->get('inputPassword')
            )
        );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();


        // do anything else you need here, like send an email
        // in this example, we are just redirecting to the homepage
        return $this->redirectToRoute('user_admin');

    }

}
