<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Application\User;

use Cuadrik\Crm\Domain\Shared\Bus\Query\Query;

class GetUserQuery implements Query
{
    private string $uuid;

    public function __construct(
        string $uuid
    )
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

}