<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Shared\Domain\Bus\Query;

interface QueryBus
{
    public function query(Query $query); // : ?Response;
}
