<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Shared\Domain\Model;


use Cuadrik\Crm\Shared\Domain\ValueObject\StringValueObject;

final class Token extends StringValueObject
{
    protected string $value;

    protected array $decoded;

    public function __construct(string $token, array $decoded = [])
    {
        $this->value = $token;
        $this->decoded = $decoded;

        parent::__construct($token);
    }

    public function decoded(): array
    {
        return $this->decoded;
    }

    public function uuid(): ?string
    {
        if(isset($this->decoded["uuid"]))
            return $this->decoded["uuid"];

        return null;
    }

}