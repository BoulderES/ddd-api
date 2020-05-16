<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Bus\Query;

interface QueryBus
{
    public function query(Query $query); // : ?Response;
}
