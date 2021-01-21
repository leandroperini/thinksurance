<?php

namespace App\DataFixtures;

use App\Entity\Permission;
use App\Factories\PermissionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class PermissionsFixtures
 * seeds the database for tests purposes
 *
 * @package App\DataFixtures
 */
class PermissionsFixtures extends Fixture
{
    public const REFERENCES = 'permission_';
    public const LIST_SIZE  = 16;

    public function load(ObjectManager $manager) {

        $permissions = [
            'create_user'          => 'User can create another user.',
            'edit_user'            => 'User can edit another user.',
            'remove_user'          => 'User can remove another user.',
            'grant_permissions'    => 'User can grant permissions to another user.',
            'list_permissions'     => 'User can list permissions from another user.',
            'add_roles'            => 'User can add roles to another user.',
            'remove_roles'         => 'User can remove roles to another user.',
            'add_content'          => 'User can add new content.',
            'remove_content'       => 'User can remove content.',
            'edit_content'         => 'User can edit content.',
            'commit'               => 'User can commit changes',
            'update_insurance_tax' => 'User can change insurance tax.',
            'apply_discount'       => 'User can apply discount to prices.',
            'edit_price'           => 'User can edit prices',
            'export_report'        => 'User can export (download) reports.',
            'generate_report'      => 'User can request report generation.',
        ];

        $idx = 0;
        foreach ($permissions as $name => $description) {
            $Permission = new Permission();
            $Permission->setName($name)->setDescription($description);

            $Permission = (new PermissionFactory([
                                                     'name'        => $name,
                                                     'description' => $description,
                                                 ]))->make();

            $manager->persist($Permission);
            $this->addReference(self::REFERENCES . $idx, $Permission);
            $idx++;
        }
        $manager->flush();
    }

}
