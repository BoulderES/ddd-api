<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Bus\Command;

interface CommandBus
{
    public function dispatch(Command $command);
}
