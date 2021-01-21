<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RolesFixtures extends Fixture implements DependentFixtureInterface
{
    public const REFERENCES = 'role_';
    public const LIST_SIZE = 7;

    public function load(ObjectManager $manager) {
        $manager->flush();

        $roles = [
            'ROLE_USER'          => 'Has an account in the system and is logged in.',
            'ROLE_USER_ADMIN'    => 'Administrates user access.',
            'ROLE_POLICY_ADMIN'  => 'Administrates insurance policy.',
            'ROLE_PRICE_ADMIN'   => 'Free will for price changing.',
            'ROLE_CONSULTANT'    => 'Read only for price info.',
            'ROLE_CONSUMER'      => 'End consumer of the platform.',
            'ROLE_DATA_ANALYZER' => 'B.I. and Managers who reads only all data.',
        ];

        $idx = 0;
        foreach ($roles as $name => $description) {

            $role = new Role();
            $role->setName($name)->setDescription($description);

            for ($permIdx = rand(); $permIdx < 16; $permIdx++) {
                $role->addPermission($this->getReference(PERMISSIONS_REFERENCE . $permIdx));
            }

            $manager->persist($role);
            $this->addReference(self::REFERENCES . $idx, $role);
            $idx++;
        }
        $manager->flush();
    }

    public function getDependencies() : array {
        return [
            PermissionsFixtures::class,
        ];
    }
}
