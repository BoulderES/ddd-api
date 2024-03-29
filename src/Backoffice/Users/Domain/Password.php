<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Domain;


use Cuadrik\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Cuadrik\Shared\Domain\ValueObject\StringValueObject;

final class Password extends StringValueObject
{

    public function __construct(string $password)
    {
        if(null === $password || "" === $password)
            ExceptionManager::throw('Password can not be empty. ' . get_called_class());

        parent::__construct($password);
    }

}