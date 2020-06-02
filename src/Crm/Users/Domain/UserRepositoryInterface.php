<?php

namespace Cuadrik\Crm\Users\Domain;


interface UserRepositoryInterface
{
    public function save(User $user): void;
}