<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Domain;


use Cuadrik\Shared\Domain\Model\UserId;
use Cuadrik\Backoffice\Users\Domain\Password;
use Cuadrik\Backoffice\Users\Domain\Roles;
use Cuadrik\Backoffice\Users\Domain\Username;

interface TokenEncoderInterface
{
    public function encodeToken(UserId $userId, Username $username, Password $password, Roles $roles): String;
}