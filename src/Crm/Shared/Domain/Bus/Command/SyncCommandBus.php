<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Shared\Domain\Bus\Command;

use Cuadrik\Crm\Shared\Domain\Bus\Command\SyncCommand as Command;

interface SyncCommandBus
{
    public function dispatchSync(Command $command);

}
