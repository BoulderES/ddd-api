<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Domain;


use Cuadrik\Shared\Domain\Model\UserId;

interface PasswordEncoder
{
    public function encodePassword(UserId $userId, Username $username, Password $plainPassword): String;

    public function isPasswordValid(UserId $userId, Username $username, Password $password, Password $plainPassword): bool;

}