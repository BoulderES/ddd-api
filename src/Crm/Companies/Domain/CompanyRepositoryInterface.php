<?php

namespace Cuadrik\Crm\Companies\Domain;


interface CompanyRepositoryInterface
{
    public function save(Company $user): void;
}