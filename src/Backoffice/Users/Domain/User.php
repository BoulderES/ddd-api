<?php

declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Domain;

//use Cuadrik\Backoffice\Companies\Domain\Company;
use Cuadrik\Shared\Domain\Aggregate\AggregateRoot;
use Cuadrik\Shared\Domain\Model\CompanyId;
use Cuadrik\Shared\Domain\Model\IsActive;
use Cuadrik\Shared\Domain\Model\Token;
use Cuadrik\Shared\Domain\Model\UpdatedAt;
use Cuadrik\Shared\Domain\Model\UserId;
use Cuadrik\Shared\Domain\Model\IsMain;
use Cuadrik\Shared\Domain\Model\IsLocked;
use Cuadrik\Shared\Domain\Model\Order;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;

final class User extends AggregateRoot
{
    private string $uuid;

    private CompanyId $companyId;

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

    public function __construct(string $uuid)
    {
        $this->uuid     = $uuid;
    }

    public static function regularUserCreator(
        UserId      $uuid,
        CompanyId   $companyId,
        Username    $username,
        Password    $password,
        Email       $email,
        Token       $token,
        Roles       $roles,
        FirstName   $firstName,
        LastName    $lastName,
        PhotoUrl    $photoUrl
    )
    {
        $user = new self($uuid->value());

        $user->recordThat(
            new UserWasCreatedDomainEvent(
                $uuid->value(),
                $username->value(),
                $companyId->value(),
                $password->value(),
                $email->value(),
                $token->value(),
                $roles->value(),
                $firstName->value(),
                $lastName->value(),
                $photoUrl->value()
            )
        );

        return $user;
    }

//    public function __construct(
//        UserId $uuid,
//        CompanyId $companyId,
//        Username $username,
//        Password $password,
//        Email $email,
//        IsMain $isMain,
//        IsActive $isActive,
//        IsLocked $isLocked,
//        Order $order
//    )
//    {
//        parent::__construct($isMain, $isActive, $isLocked, $order);
//
//        $this->uuid     = $uuid->value();
//        $this->companyId  = $companyId;
//        $this->username = $username;
//        $this->password = $password;
//        $this->email    = $email;
//    }
//
//    public static function regularUserCreator(
//        UserId $uuid,
//        CompanyId $companyId,
//        Username $username,
//        Password $password,
//        Email $email,
//        Token $token,
//        Roles $roles
//    )
//    {
//        // TODO - modify to default values
//        $firstName      = FirstName::fromString("");
//        $lastName       = LastName::fromString("");
//        $commercialName = CommercialName::fromString("");
//        $termsAccepted  = TermsAccepted::fromBool(true);
//        $photoUrl       = PhotoUrl::fromString("");
//        $latitude       = Latitude::fromString("");
//        $longitude      = Longitude::fromString("");
//        $isMain         = IsMain::fromBool(true);
//        $isActive       = IsActive::fromBool(true);
//        $isLocked       = IsLocked::fromBool(false);
//        $order          = Order::fromInt(1);
//
//        $user = new self(
//            $uuid,
//            $companyId,
//            $username,
//            $password,
//            $email,
//            $isMain,
//            $isActive,
//            $isLocked,
//            $order
//        );
//
//        $user->token            = $token;
//        $user->roles            = $roles;
//        $user->firstName        = $firstName;
//        $user->lastName         = $lastName;
//        $user->commercialName   = $commercialName;
//        $user->termsAccepted    = $termsAccepted;
//        $user->photoUrl         = $photoUrl;
//        $user->latitude         = $latitude;
//        $user->longitude        = $longitude;
//        $user->isMain           = $isMain;
//        $user->isActive         = $isActive;
//        $user->isLocked         = $isLocked;
//
//        $user->recordThat(new UserWasCreatedDomainEvent($uuid->value(), $username->value(), $companyId->value()));
//
//        return $user;
//
//    }

    public function doSignIn()
    {

        $this->recordThat(new UserDidSignInDomainEvent($this->uuid, $this->username->value(), $this->companyId->value()));

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

        return $this;
    }

    public function refreshToken(Token $token): User
    {
        $this->token = $token;

        return $this;
    }

    public function token(): Token
    {
        return $this->token;
    }

    public function isActive(): IsActive
    {
        return $this->isActive;
    }

    public function isMain(): IsMain
    {
        return $this->isMain;
    }

    public function isLocked(): IsLocked
    {
        return $this->isLocked;
    }

    public function password(): Password
    {
        return $this->password;
    }

    public function uuid(): UserId
    {
        return new UserId($this->uuid);
    }

    public function username(): Username
    {
        return $this->username;
    }

    public function displayName(): DisplayName
    {
        return new DisplayName($this->firstName->value() . " " . $this->lastName->value());
//        return new DisplayName(" ");
    }

    public function firstname(): FirstName
    {
        return $this->firstName;
    }

    public function lastname(): LastName
    {
        return $this->lastName;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function photoUrl(): PhotoUrl
    {
        return $this->photoUrl;
    }

    public function roles(): Roles
    {
        return $this->roles;
    }

    protected function applyUserWasCreatedDomainEvent(
        UserWasCreatedDomainEvent $event
    ) {
        $this->username     = new Username($event->username());
        $this->companyId    = new CompanyId($event->companyId());
        $this->password     = new Password($event->password());
        $this->email        = new Email($event->email());
        $this->token        = new Token($event->token());
        $this->roles        = new Roles($event->roles());
        $this->firstName    = new FirstName($event->firstName());
        $this->lastName     = new LastName($event->lastName());
        $this->photoUrl     = new PhotoUrl($event->photoUrl());
        var_export($this);
        exit;
    }

    protected function applyUserWasRenamedDomainEvent(
        UserWasRenamedDomainEvent $event
    ) {
        $this->username = new Username($event->username());
    }
    protected function applyUserDidSignInDomainEvent(
        UserDidSignInDomainEvent $event
    ) {
//        $this->username = new Username($event->username());
    }

}
