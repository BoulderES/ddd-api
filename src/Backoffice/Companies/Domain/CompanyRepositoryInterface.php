<?php

namespace Cuadrik\Backoffice\Companies\Domain;


interface CompanyRepositoryInterface
{
    public function save(Company $user): void;
}