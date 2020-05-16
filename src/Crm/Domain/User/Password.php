<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\User;


use Cuadrik\Crm\Domain\Shared\ExceptionHandler;
use Cuadrik\Crm\Domain\Shared\ValueObject\StringValueObject;

final class Password extends StringValueObject
{

    public function __construct(string $password)
    {
        if(null === $password || "" === $password)
            ExceptionHandler::throw('Password can not be empty.', get_called_class());

        parent::__construct($password);
    }

}