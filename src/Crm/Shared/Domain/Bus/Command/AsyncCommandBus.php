<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Shared\Domain\Bus\Command;

use Cuadrik\Crm\Shared\Domain\Bus\Command\AsyncCommand as Command;

interface AsyncCommandBus
{
    public function dispatchAsync(Command $command);

}
