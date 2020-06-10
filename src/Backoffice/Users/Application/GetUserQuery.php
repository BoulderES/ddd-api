<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Application;

use Cuadrik\Shared\Domain\Bus\Query\Query;

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