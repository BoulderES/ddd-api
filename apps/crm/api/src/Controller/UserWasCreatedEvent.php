<?php


namespace Cuadrik\Apps\Crm\Api\Controller;


class UserWasCreatedEvent
{
    /** @var string */
    public $id;

    /** @var string */
    public $username;

    /** @var string */
    public $passwordHash;

    /**@var string */
    public $firstName;

    /**@var string */
    public $lastName;

    /** @var string */
    public $roleName;

    public function __construct(
        string $id,
        string $username,
        string $passwordHash,
        string $firstName,
        string $lastName,
        string $roleName
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->roleName = $roleName;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            $data['id'],
            $data['username'],
            $data['password_hash'],
            $data['first_name'],
            $data['last_name'],
            $data['role_name']
        );
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'password_hash' => $this->passwordHash,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'role_name' => $this->roleName,
        ];
    }

}