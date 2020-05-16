<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\User;


use Cuadrik\Crm\Domain\Shared\ValueObject\BooleanValueObject;

final class TermsAccepted extends BooleanValueObject
{
    public function __construct($termsAccepted)
    {
        if(null === $termsAccepted || "" === $termsAccepted)
            $termsAccepted =  true;

        parent::__construct($termsAccepted);
    }

}