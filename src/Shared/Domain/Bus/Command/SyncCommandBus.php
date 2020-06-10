<?php
declare(strict_types = 1);


namespace Cuadrik\Shared\Domain\Bus\Command;

use Cuadrik\Shared\Domain\Bus\Command\SyncCommand as Command;

interface SyncCommandBus
{
    public function dispatchSync(Command $command);

}
