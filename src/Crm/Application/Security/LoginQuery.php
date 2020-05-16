<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Application\Security;

use Cuadrik\Crm\Domain\Shared\Bus\Query\Query;

class LoginQuery implements Query
{
    private string $username;

    private string $password;

    public function __construct(
        string $username,
        string $password
    )
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }


}