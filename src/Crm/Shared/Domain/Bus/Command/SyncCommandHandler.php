<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Shared\Domain\Bus\Command;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface SyncCommandHandler extends MessageHandlerInterface
{
}
