<?php

namespace App\Entity\User;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;


    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="users")
     */
    private $Roles;

    /**
     * @ORM\ManyToMany(targetEntity=Permission::class, mappedBy="users")
     */
    private $Permissions = [];

    public function __construct() {
        $this->Roles = new ArrayCollection();
        $this->Permissions = new ArrayCollection();
    }

    public function getId() : ?int {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface::getUsername()
     */
    public function getUsername() : string {
        return (string)$this->username;
    }

    public function setUsername(string $username) : self {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface::getPassword()
     */
    public function getPassword() : string {
        return (string)$this->password;
    }

    public function setPassword(string $password) : self {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface::getSalt()
     */
    public function getSalt() : ?string {
        return hash('md5', 'thinksurance_passwd_encrypt');
    }

    /**
     * @see UserInterface::eraseCredentials()
     */
    public function eraseCredentials() {
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
            $Role->addUser($this);
        }

        return $this;
    }

    public function removeRole(Role $Role) : self {
        if ($this->Roles->removeElement($Role)) {
            $Role->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Permission[]
     */
    public function getPermissions() : Collection {
        return $this->Roles;
    }

    public function addPermission(Permission $Permission) : self {
        if (!$this->Permissions->contains($Permission)) {
            $this->Permissions[] = $Permission;
            $Permission->addUser($this);
        }

        return $this;
    }

    public function removePermission(Permission $Permission) : self {
        if ($this->Permissions->removeElement($Permission)) {
            $Permission->removeUser($this);
        }

        return $this;
    }
}
