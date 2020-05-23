<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Domain\User;


use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Companies\Domain\User\Password;
use Cuadrik\Crm\Companies\Domain\User\Roles;
use Cuadrik\Crm\Companies\Domain\User\Username;

interface TokenEncoderInterface
{
    public function encodeToken(UserId $userId, Username $username, Password $password, Roles $roles): String;
}