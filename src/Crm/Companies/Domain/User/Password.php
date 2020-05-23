<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Domain\User;


use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Cuadrik\Crm\Shared\Domain\ValueObject\StringValueObject;

final class Password extends StringValueObject
{

    public function __construct(string $password)
    {
        if(null === $password || "" === $password)
            ExceptionManager::throw('Password can not be empty. ' . get_called_class());

        parent::__construct($password);
    }

}