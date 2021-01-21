<?php


namespace App\Factories;


use App\Contracts\FactoryInterface;
use App\Entity\Permission;
use App\Entity\Role;

class RoleFactory implements FactoryInterface
{
    private array $data = [];

    public function __construct(array $data = []) {
        $this->data = $data;
    }

    public function make(array $data = []) : Role {
        $Obj = new Role();

        $this->parseProperties(array_merge($this->data, $data))
             ->makePermissions($this->data['permissions']);

        $Obj->setName($this->data['name'] ?? '');
        $Obj->setDescription($this->data['description'] ?? '');


        foreach ($this->data['permissions'] as $Permission) {
            $Obj->addPermission($Permission);
        }
        return $Obj;
    }

    private function parseProperties(array $data) : self {
        $this->data['name']        = $data['name'] ?? '';
        $this->data['description'] = $data['description'] ?? '';
        $this->data['permissions'] = $data['permissions'] ?? [];
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
}