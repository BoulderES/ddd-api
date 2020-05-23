<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Domain\User;


use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Cuadrik\Crm\Shared\Domain\ValueObject\StringValueObject;

final class Username extends StringValueObject
{

    public function __construct(string $username)
    {
        if(null === $username || "" === $username)
            ExceptionManager::throw('Username doesn\'t exist in request. ' . get_called_class());

        parent::__construct($username);
    }

}