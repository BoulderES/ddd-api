<?php

namespace Cuadrik\Crm\Companies\Domain\User;


interface UserRepositoryInterface
{
    public function save(User $user): void;
}