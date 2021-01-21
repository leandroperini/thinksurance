<?php


namespace App\Factories;


use App\Contracts\FactoryInterface;
use App\Entity\Permission;
use App\Entity\Role;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactory implements FactoryInterface
{
    private array $data = [];

    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(array $data = []) {
        $this->data = $data;
    }

    public function make(array $data = []) : User {
        $Obj = new User();

        $this->parseProperties(array_merge($this->data, $data))
             ->makePermissions($this->data['permissions'])
             ->makeRoles($this->data['roles']);

        $Obj->setUsername($this->data['username'] ?? '');

        foreach ($this->data['permissions'] as $Permission) {
            $Obj->addPermission($Permission);
        }

        $passWd = $this->passwordEncoder->encodePassword($Obj, $this->data['password']);
        $Obj->setPassword($passWd);

        return $Obj;
    }

    public function setPasswordEncoder(UserPasswordEncoderInterface $encoder) : self {
        $this->passwordEncoder = $encoder;
        return $this;
    }

    private function parseProperties(array $data) : self {
        $this->data['name']        = $data['username'] ?? '';
        $this->data['password']    = $data['password'] ?? '';
        $this->data['permissions'] = $data['permissions'] ?? [];
        $this->data['roles']       = $data['roles'] ?? [];
        return $this;
    }

    private function makePermissions($permissions) : self {
        $permissionsObjs = [];
        foreach ($permissions as $permissionAttributes) {
            if ($permissionAttributes instanceof Permission) {
                $permissionsObjs[] = $permissionAttributes;
                continue;
            }

            $permissionsObjs[] = (new PermissionFactory($permissionAttributes))->make();
        }
        $this->data['permissions'] = $permissionsObjs;
        return $this;
    }

    private function makeRoles($roles) : self {
        $rolesObjs = [];
        foreach ($roles as $roleAttributes) {
            if ($roleAttributes instanceof Role) {
                $rolesObjs[] = $roleAttributes;
                continue;
            }
            $rolesObjs[] = (new PermissionFactory($roleAttributes))->make();
        }
        $this->data['roles'] = $rolesObjs;
        return $this;
    }
}