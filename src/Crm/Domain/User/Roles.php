<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\User;


use Cuadrik\Crm\Domain\Shared\ValueObject\StringValueObject;

final class Roles extends StringValueObject
{
    const REGULAR_USER_ROLE = "ROLE_REGULAR";
    const BASIC_USER_ROLE = "ROLE_USER";
    const ADMIN_USER_ROLE =  "ROLE_ADMIN";

}