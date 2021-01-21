<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\ManyToMany(targetEntity=Permission::class, inversedBy="Roles")
     */
    private Collection $Permissions;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="Roles")
     */
    private Collection $Users;

    public function __construct() {
        $this->Permissions = new ArrayCollection();
        $this->Users       = new ArrayCollection();
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

    public function setDescription(?string $description) : self {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Permission[]
     */
    public function getPermissions() : Collection {
        return $this->Permissions;
    }

    public function addPermission(Permission $Permission) : self {
        if (!$this->Permissions->contains($Permission)) {
            $this->Permissions[] = $Permission;
        }

        return $this;
    }

    public function removePermission(Permission $Permission) : self {
        $this->Permissions->removeElement($Permission);

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
        }

        return $this;
    }

    public function removeUser(User $User) : self {
        $this->Users->removeElement($User);

        return $this;
    }
}
