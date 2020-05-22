<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Bus\Command;

use Cuadrik\Crm\Infrastructure\Symfony\Bus\MessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface CommandHandler extends MessageHandlerInterface
{
}
