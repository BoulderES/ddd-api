<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Domain;


use Cuadrik\Shared\Domain\ValueObject\BooleanValueObject;

final class TermsAccepted extends BooleanValueObject
{
    public function __construct($termsAccepted)
    {
        if(null === $termsAccepted || "" === $termsAccepted)
            $termsAccepted =  true;

        parent::__construct($termsAccepted);
    }

}