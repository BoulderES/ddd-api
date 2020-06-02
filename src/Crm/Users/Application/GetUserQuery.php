<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Users\Application;

use Cuadrik\Crm\Shared\Domain\Bus\Query\Query;

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