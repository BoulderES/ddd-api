<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Domain\User;


use Cuadrik\Crm\Shared\Domain\ValueObject\BooleanValueObject;

final class TermsAccepted extends BooleanValueObject
{
    public function __construct($termsAccepted)
    {
        if(null === $termsAccepted || "" === $termsAccepted)
            $termsAccepted =  true;

        parent::__construct($termsAccepted);
    }

}