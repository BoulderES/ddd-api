<?php
declare(strict_types = 1);


namespace Cuadrik\Shared\Domain\Bus\Command;

use Cuadrik\Shared\Domain\Bus\Command\AsyncCommand as Command;

interface AsyncCommandBus
{
    public function dispatchAsync(Command $command);

}
