<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Bus\Query;

use Cuadrik\Crm\Infrastructure\Symfony\Bus\MessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface QueryHandler extends MessageHandlerInterface
{
}
