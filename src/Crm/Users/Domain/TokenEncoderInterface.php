<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Users\Domain;


use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Users\Domain\Password;
use Cuadrik\Crm\Users\Domain\Roles;
use Cuadrik\Crm\Users\Domain\Username;

interface TokenEncoderInterface
{
    public function encodeToken(UserId $userId, Username $username, Password $password, Roles $roles): String;
}