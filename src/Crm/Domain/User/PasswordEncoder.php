<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\User;


use Cuadrik\Crm\Domain\Shared\Model\UserId;

interface PasswordEncoder
{
    public function encodePassword(UserId $userId, Username $username, Password $plainPassword): String;

    public function isPasswordValid(UserId $userId, Username $username, Password $password, Password $plainPassword): bool;

}