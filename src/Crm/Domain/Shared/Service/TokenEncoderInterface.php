<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Service;


use Cuadrik\Crm\Domain\Shared\Model\UserId;
use Cuadrik\Crm\Domain\User\Password;
use Cuadrik\Crm\Domain\User\Roles;
use Cuadrik\Crm\Domain\User\Username;

interface TokenEncoderInterface
{
    public function encodeToken(UserId $userId, Username $username, Password $password, Roles $roles): String;
}