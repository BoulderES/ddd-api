<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Application\Security;

use Cuadrik\Crm\Shared\Domain\Bus\Command\Command;

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