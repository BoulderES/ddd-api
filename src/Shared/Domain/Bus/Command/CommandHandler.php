<?php
declare(strict_types = 1);


namespace Cuadrik\Shared\Domain\Bus\Command;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface CommandHandler extends MessageHandlerInterface
{
}
