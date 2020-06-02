<?php

namespace Cuadrik\Crm\Users\Infrastructure\Symfony;

use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Users\Domain\Password;
use Cuadrik\Crm\Users\Domain\Roles;
use Cuadrik\Crm\Users\Domain\Username;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUser implements UserInterface
{
    private string $username;

    private $roles = [];

    private string $password;

    private string $uuid;

    /**
     * SecurityUser constructor.
     * @param UserId $uuid
     * @param Username $username
     * @param Password $password
     * @param Roles $roles
     */
    public function __construct(UserId $uuid, Username $username, Password $password = null, Roles $roles= null)
    {
        $this->username = $username->value();
        $this->uuid = $uuid->value();

        if($password)
            $this->password = $password->value();
        if($roles)
            $this->roles = [$roles->value()];
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return "";
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
