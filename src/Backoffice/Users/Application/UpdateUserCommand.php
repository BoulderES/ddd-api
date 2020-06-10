<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Application;

use Cuadrik\Shared\Domain\Bus\Command\Command;

class UpdateUserCommand implements Command
{

    private string $uuid;
    private string $username;
    private string $email;
    private string $password;
    private string $photoUrl;
    private string $firstName;
    private string $lastName;

    public function __construct(
        string $uuid,
        string $username,
        string $password,
        string $email,
        string $photoUrl,
        string $firstName = "",
        string $lastName = ""
    )
    {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->photoUrl = $photoUrl;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPhotoUrl(): string
    {
        return $this->photoUrl;
    }

}