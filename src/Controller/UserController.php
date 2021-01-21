<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin() : Response {
        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('auth_form_login');
        }
        return $this->json([
                               'message'  => 'you are logged in',
                               'username' => $user->getUsername(),
                               'roles'    => $user->getRoles(),
                           ]);
    }
}
