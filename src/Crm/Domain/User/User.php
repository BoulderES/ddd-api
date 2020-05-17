<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\User;

use Cuadrik\Crm\Domain\Company\Company;
use Cuadrik\Crm\Domain\Shared\Aggregate\AggregateRoot;
use Cuadrik\Crm\Domain\Shared\Model\IsActive;
use Cuadrik\Crm\Domain\Shared\Model\Token;
use Cuadrik\Crm\Domain\Shared\Model\UserId;
use Cuadrik\Crm\Domain\Shared\Model\IsMain;
use Cuadrik\Crm\Domain\Shared\Model\Locked;
use Cuadrik\Crm\Domain\Shared\Model\Order;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
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
        Locked $locked,
        Order $order
    )
    {
        parent::__construct($isMain, $isActive, $locked, $order);

        $this->uuid = $uuid;
        $this->company = $company;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
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
        $firstName = "";
        $lastName = "";
        $commercialName = "";
        $termsAccepted = true;
        $photoUrl = "";
        $latitude = "";
        $longitude = "";
        $isMain = true;
        $isActive = true;
        $locked = false;
        $order = 1;

        $user = new self(
            $uuid,
            $company,
            $username,
            $password,
            $email,
            new IsMain($isMain),
            new IsActive($isActive),
            new Locked($locked),
            new Order($order)
        );

        $user->token = $token;
        $user->roles = $roles;
        $user->firstName = new FirstName($firstName);
        $user->lastName = new LastName($lastName);
        $user->commercialName = new CommercialName($commercialName);
        $user->termsAccepted = new TermsAccepted($termsAccepted);
        $user->photoUrl = new PhotoUrl($photoUrl);
        $user->latitude = new Latitude($latitude);
        $user->longitude = new Longitude($longitude);
        $user->isMain = new IsMain($isMain);
        $user->isActive = new IsActive($isActive);
        $user->locked = new Locked($locked);
        $user->order = new Order($order);

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
        $this->username = $username;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->photoUrl = $photoUrl;

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
        return $this->token->value();
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
        return $this->locked->value();
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
