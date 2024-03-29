<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Domain;


use Cuadrik\Shared\Domain\ValueObject\StringValueObject;

final class PhotoUrl extends StringValueObject
{
    const PHOTO_URL = "profile.jpg";

    public function __construct(string $photoUrl)
    {
        if(null === $photoUrl || "" === $photoUrl)
            $photoUrl = self::PHOTO_URL;

        parent::__construct($photoUrl);
    }

}