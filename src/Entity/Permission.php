<?php

namespace App\Entity;

use App\Contracts\ArrayableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PermissionRepository::class)
 */
class Permission implements ArrayableInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="Permissions")
     */
    private Collection $Roles;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="Permissions")
     */
    private Collection $Users;

    public function __construct() {
        $this->Roles = new ArrayCollection();
        $this->Users = new ArrayCollection();
    }

    public function getId() : ?int {
        return $this->id;
    }

    public function getName() : ?string {
        return $this->name;
    }

    public function setName(string $name) : self {
        $this->name = $name;

        return $this;
    }

    public function getDescription() : ?string {
        return $this->description;
    }

    public function setDescription(string $description) : self {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRoles() : Collection {
        return $this->Roles;
    }

    public function addRole(Role $Role) : self {
        if (!$this->Roles->contains($Role)) {
            $this->Roles[] = $Role;
            $Role->addPermission($this);
        }

        return $this;
    }

    public function removeRole(Role $Role) : self {
        if ($this->Roles->removeElement($Role)) {
            $Role->removePermission($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers() : Collection {
        return $this->Users;
    }

    public function addUser(User $User) : self {
        if (!$this->Users->contains($User)) {
            $this->Users[] = $User;
            $User->addPermission($this);
        }

        return $this;
    }

    public function removeUser(User $User) : self {
        if ($this->Users->removeElement($User)) {
            $User->removePermission($this);
        }

        return $this;
    }

    public function toArray() : array {
        return [
            'name'        => $this->getName(),
            'description' => $this->getDescription(),
        ];

    }


}
