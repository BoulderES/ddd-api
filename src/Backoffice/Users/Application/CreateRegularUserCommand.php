<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Application;

use Cuadrik\Shared\Domain\Bus\Command\Command;

class CreateRegularUserCommand implements Command
{

    private string $uuid;
    private string $companyUuid;
    private string $username;
    private string $email;
    private string $password;
    private string $photoUrl;

    private function __construct(
        string $uuid,
        string $companyUuid,
        string $username,
        string $password,
        string $email,
        string $photoUrl
    )
    {
        $this->uuid = $uuid;
        $this->companyUuid = $companyUuid;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->photoUrl = $photoUrl;
    }

    public static function fromArray(array $array)
    {
        return new static(
            (string) $array['userId'],
            (string) $array['companyId'],
            (string) $array['username'],
            (string) $array['password'],
            (string) $array['email'],
            (string) $array['photoUrl']
        );
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

    public function getCompanyUuid(): string
    {
        return $this->companyUuid;
    }

    public function getPhotoUrl(): string
    {
        return $this->photoUrl;
    }

}