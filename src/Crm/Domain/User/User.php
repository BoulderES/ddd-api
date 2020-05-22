<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\User;

use Cuadrik\Crm\Domain\Shared\Aggregate\AggregateRoot;
use Cuadrik\Crm\Domain\Shared\Model\CompanyId;
use Cuadrik\Crm\Domain\Shared\Model\IsActive;
use Cuadrik\Crm\Domain\Shared\Model\Token;
use Cuadrik\Crm\Domain\Shared\Model\UserId;
use Cuadrik\Crm\Domain\Shared\Model\IsMain;
use Cuadrik\Crm\Domain\Shared\Model\IsLocked;
use Cuadrik\Crm\Domain\Shared\Model\Order;
use Cuadrik\Crm\Domain\Shared\Utils;
use Cuadrik\Crm\Domain\Shared\Uuid;
use DateTimeImmutable;

final class User extends AggregateRoot
{
    private string $uuid;

    private Company $companyId;

    private string $parent;

    private string $username;

    private string $email;

    private string $password;

    private string $token;

    private string $firstName;

    private string $lastName;

    private string $commercialName;

    private string $latitude;

    private string $longitude;

    private string $roles;

    private bool $termsAccepted;

    private string $photoUrl;


    public function __toString()
    {
        return $this->uuid;
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
        CompanyId $companyId,
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

        $this->uuid     = $uuid->value();
        $this->companyId  = $companyId->value();
        $this->username = $username->value();
        $this->password = $password->value();
        $this->email    = $email->value();
    }

    public static function regularUserCreator(
        UserId $uuid,
        CompanyId $companyId,
        Username $username,
        Password $password,
        Email $email,
        Token $token,
        Roles $roles
    )
    {
        // TODO - modify to default values
        $firstName      = "";
        $lastName       = "";
        $commercialName = "";
        $termsAccepted  = true;
        $photoUrl       = "";
        $latitude       = "";
        $longitude      = "";
        $isMain         = true;
        $isActive       = true;
        $isLocked       = false;
        $order          = 1;

        $user = new self(
            $uuid,
            $companyId,
            $username,
            $password,
            $email,
            new IsMain($isMain),
            new IsActive($isActive),
            new IsLocked($isLocked),
            new Order($order)
        );

        $user->token            = $token->value();
        $user->roles            = $roles->value();
        $user->firstName        = $firstName;
        $user->lastName         = LastName::fromString($lastName)->value();
        $user->commercialName   = CommercialName::fromString($commercialName)->value();
        $user->termsAccepted    = TermsAccepted::fromBool($termsAccepted)->value();
        $user->photoUrl         = PhotoUrl::fromString($photoUrl)->value();
        $user->latitude         = Latitude::fromString($latitude)->value();
        $user->longitude        = Longitude::fromString($longitude)->value();
        $user->isMain           = IsMain::fromBool($isMain)->value();
        $user->isActive         = IsActive::fromBool($isActive)->value();
        $user->isLocked         = IsLocked::fromBool($isLocked)->value();
        $user->order            = Order::fromInt($order)->value();

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
        $this->username     = $username->value();
        $this->email        = $email->value();
        $this->firstName    = $firstName->value();
        $this->lastName     = $lastName->value();
        $this->photoUrl     = $photoUrl->value();

        if( "" !== $password )
            $this->password = $password->value();
    }

    public function refreshToken(Token $token)
    {
        $this->token = $token->value();

        return $this;
    }

    public function token()
    {
        return Token::fromString($this->token);
    }

    public function isActive()
    {
        return IsActive::fromBool($this->isActive);
    }

    public function isMain()
    {
        return IsMain::fromBool($this->isMain);
    }

    public function isLocked()
    {
        return IsLocked::fromBool($this->isLocked);
    }

    public function password()
    {
        return Password::fromString($this->password);
    }

    public function uuid()
    {
        return UserId::fromString($this->uuid);
    }

    public function username()
    {
        return Username::fromString($this->username);
    }

    public function displayName()
    {
        return $this->firstName . " " . $this->lastName;
    }

    public function firstname()
    {
        return FirstName::fromString($this->firstName);
    }

    public function lastname()
    {
        return LastName::fromString($this->lastName);
    }

    public function email()
    {
        return Email::fromString($this->email);
    }

    public function photoUrl()
    {
        return PhotoUrl::fromString($this->photoUrl);
    }

    public function roles()
    {
        return Roles::fromString($this->roles);
    }


}
