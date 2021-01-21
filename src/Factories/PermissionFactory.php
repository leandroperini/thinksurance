<?php


namespace App\Factories;


use App\Contracts\FactoryInterface;
use App\Entity\Permission;

class PermissionFactory implements FactoryInterface
{
    private array $data = [];

    public function __construct(array $data = []) {
        $this->data = $data;
    }

    public function make(array $data = []) : Permission {
        $this->parseProperties(array_merge($this->data, $data));

        $Obj = new Permission();
        $Obj->setName($this->data['name'] ?? '');
        $Obj->setDescription($this->data['description'] ?? '');

        return $Obj;
    }

    private function parseProperties(array $data) : self {
        $this->data['name']        = $data['name'] ?? '';
        $this->data['description'] = $data['description'] ?? '';
        return $this;
    }
}