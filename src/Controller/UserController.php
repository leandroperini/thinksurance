<?php

namespace App\Controller;

use App\Entity\User;
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
        return $this->json([
                               'message'  => 'you are logged in',
                               'username' => $this->getUser()->getUsername(),
                               'roles'    => $this->getUser()->getRoles(),
                           ]);
    }
}
