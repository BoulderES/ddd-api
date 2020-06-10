<?php

namespace Cuadrik\Backoffice\Users\Domain;


interface UserRepositoryInterface
{
    public function save(User $user): void;
}