<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Shared\Domain\Bus\Command;

interface SyncCommandBus
{
    public function dispatchWithResponse(SyncCommand $command); //: void;
}