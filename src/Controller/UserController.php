<?php

namespace App\Controller;

use App\Repository\UserRepository;
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
     * @param \App\Repository\UserRepository $userRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function admin(UserRepository $userRepository) : Response {
        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('auth_form_login');
        }


        $userData = $userRepository->findOneBy([
                                                   'username' => $user->getUsername(),
                                               ]);
        return $this->json([
                               'message'           => 'you are logged in',
                               'authorizationData' => $userData->toArray(),
                           ]);
    }

    /**
     * Allows to list every username in the database, for test purposes
     * @Route("/list", name="list")
     * @param \App\Repository\UserRepository $userRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAvailableUsers(UserRepository $userRepository) : Response {
        return $this->json(array_map(static function ($User){
            return $User->getUsername();
        }, $userRepository->findAll()));
    }
}
