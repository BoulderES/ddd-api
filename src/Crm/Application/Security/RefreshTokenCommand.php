<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Application\Security;

use Cuadrik\Crm\Domain\Shared\Bus\Command\Command;

class RefreshTokenCommand implements Command
{
    private string $token;

    public function __construct(
        string $token
    )
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }


}