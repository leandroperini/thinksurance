<?php

namespace App\DataFixtures;

use App\Factories\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager) {
        $manager->flush();

        $usedUsernames = [];
        for ($idx = 0; $idx < 50; $idx++) {

            $username = 'user_0001';
            $password = '0001';

            while ($usedUsernames[$username] ?? false) {
                $password = str_pad((string)rand(0, 9999), 4, 0, STR_PAD_LEFT);
                $username = 'user_' . $password;
            }

            $usedUsernames[$username] = true;

            $userData = [
                'username' => $username,
                'password' => $password,
            ];

            for ($roleIdx = rand(0, RolesFixtures::LIST_SIZE); $roleIdx < 3; $roleIdx++) {
                $userData['roles'][] = $this->getReference(RolesFixtures::REFERENCES . $roleIdx);
            }

            for ($permIdx = rand(0, PermissionsFixtures::LIST_SIZE); $permIdx < 5; $permIdx++) {
                $userData['permissions'][] = $this->getReference(PermissionsFixtures::REFERENCES . $permIdx);
            }

            $User = (new UserFactory($userData))->setPasswordEncoder($this->encoder)->make();
            $manager->persist($User);
        }
        $manager->flush();
    }


    public function getDependencies() : array {
        return [
            RolesFixtures::class,
            PermissionsFixtures::class,
        ];
    }
}
