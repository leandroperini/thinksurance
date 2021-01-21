<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManager;
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

        $password = str_pad((string)rand(0, 9999), 4, 0, STR_PAD_LEFT);

        for ($idx = 0; $idx < 50; $idx++) {
            $user     = new User();
            $password = $this->encoder->encodePassword($user, $password);

            $user->setUsername('user_' . $password)->setPassword($password);

            for ($roleIdx = rand(0, RolesFixtures::LIST_SIZE); $roleIdx < 3; $roleIdx++) {
                /**
                 * @var \App\Entity\Role $role
                 */
                $role = $this->getReference(RolesFixtures::REFERENCES . $roleIdx);
                $manager->persist($role);
                $user->addRole($role);
            }
            $manager->persist($user);

            for ($permIdx = rand(0, PermissionsFixtures::LIST_SIZE); $permIdx < 5; $permIdx++) {
                /**
                 * @var \App\Entity\Permission $permission
                 */
                $permission = $this->getReference(PermissionsFixtures::REFERENCES . $permIdx);
                $user->addPermission($permission);
            }

            $manager->persist($user);
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
