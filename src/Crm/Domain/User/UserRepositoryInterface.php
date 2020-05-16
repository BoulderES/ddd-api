<?php

namespace Cuadrik\Crm\Domain\User;


interface UserRepositoryInterface
{
    public function save(User $user): void;
}