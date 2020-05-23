<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Domain\User;

use Cuadrik\Crm\Companies\Domain\Company\Company;
use Cuadrik\Crm\Shared\Domain\Aggregate\AggregateRoot;
use Cuadrik\Crm\Shared\Domain\Model\IsActive;
use Cuadrik\Crm\Shared\Domain\Model\Token;
use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Shared\Domain\Model\IsMain;
use Cuadrik\Crm\Shared\Domain\Model\IsLocked;
use Cuadrik\Crm\Shared\Domain\Model\Order;
use Cuadrik\Crm\Shared\Domain\Utils\Utils;
use Cuadrik\Crm\Shared\Domain\ValueObject\Uuid;
use DateTimeImmutable;

final class User extends AggregateRoot
{
    private UserId $uuid;

    private Company $company;

    private User $parent;

    private Username $username;

    private Email $email;

    private Password $password;

    private Token $token;

    private FirstName $firstName;

    private LastName $lastName;

    private CommercialName $commercialName;

    private Latitude $latitude;

    private Longitude $longitude;

    private Roles $roles;

    private TermsAccepted $termsAccepted;

    private PhotoUrl $photoUrl;


    public function __toString()
    {
        return $this->uuid->value();
    }
//
//    public function dummyUser($object)
//    {
//        $vars=is_object($object)?get_object_vars($object):$object;
//        if(!is_array($vars)) throw Exception('no props to import into the object!');
//        foreach ($vars as $key => $value) {
//            $this->$key = $value;
//        }
//
//    }

    public function __construct(
        UserId $uuid,
        Company $company,
        Username $username,
        Password $password,
        Email $email,
        IsMain $isMain,
        IsActive $isActive,
        IsLocked $isLocked,
        Order $order
    )
    {
        parent::__construct($isMain, $isActive, $isLocked, $order);

        $this->uuid     = $uuid;
        $this->company  = $company;
        $this->username = $username;
        $this->password = $password;
        $this->email    = $email;
    }

    public static function regularUserCreator(
        UserId $uuid,
        Company $company,
        Username $username,
        Password $password,
        Email $email,
        Token $token,
        Roles $roles
    )
    {
        // TODO - modify to default values
        $firstName      = FirstName::fromString("");
        $lastName       = LastName::fromString("");
        $commercialName = CommercialName::fromString("");
        $termsAccepted  = TermsAccepted::fromBool(true);
        $photoUrl       = PhotoUrl::fromString("");
        $latitude       = Latitude::fromString("");
        $longitude      = Longitude::fromString("");
        $isMain         = IsMain::fromBool(true);
        $isActive       = IsActive::fromBool(true);
        $isLocked       = IsLocked::fromBool(false);
        $order          = Order::fromInt(1);

        $user = new self(
            $uuid,
            $company,
            $username,
            $password,
            $email,
            $isMain,
            $isActive,
            $isLocked,
            $order
        );

        $user->token            = $token;
        $user->roles            = $roles;
        $user->firstName        = $firstName;
        $user->lastName         = $lastName;
        $user->commercialName   = $commercialName;
        $user->termsAccepted    = $termsAccepted;
        $user->photoUrl         = $photoUrl;
        $user->latitude         = $latitude;
        $user->longitude        = $longitude;
        $user->isMain           = $isMain;
        $user->isActive         = $isActive;
        $user->isLocked         = $isLocked;

        $eventId = Uuid::random()->value();
        $occurredOn = Utils::dateToString(new DateTimeImmutable());

        $user->record(new UserCreatedDomainEvent($uuid->value(), $username->value(),$eventId,$occurredOn));


        return $user;

    }

    public function update(
        Username $username,
        Password $password,
        Email $email,
        PhotoUrl $photoUrl,
        FirstName $firstName,
        LastName $lastName
    )
    {
        $this->username     = $username;
        $this->email        = $email;
        $this->firstName    = $firstName;
        $this->lastName     = $lastName;
        $this->photoUrl     = $photoUrl;

        if( "" !== $password )
            $this->password = $password;
    }

    public function refreshToken(Token $token)
    {
        $this->token = $token;

        return $this;
    }

    public function token()
    {
        return $this->token;
    }

    public function isActive()
    {
        return $this->isActive->value();
    }

    public function isMain()
    {
        return $this->isMain->value();
    }

    public function isLocked()
    {
        return $this->isLocked->value();
    }

    public function password()
    {
        return $this->password->value();
    }

    public function uuid()
    {
        return $this->uuid->value();
    }

    public function username()
    {
        return $this->username->value();
    }

    public function displayName()
    {
        return $this->firstName->value() . " " . $this->lastName->value();
    }

    public function firstname()
    {
        return $this->firstName->value();
    }

    public function lastname()
    {
        return $this->lastName->value();
    }

    public function email()
    {
        return $this->email->value();
    }

    public function photoUrl()
    {
        return $this->photoUrl->value();
    }

    public function roles()
    {
        return $this->roles->value();
    }


}
