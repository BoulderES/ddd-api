<?php
declare(strict_types = 1);


namespace Cuadrik\Shared\Domain\Bus\Query;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface QueryHandler extends MessageHandlerInterface
{
}
