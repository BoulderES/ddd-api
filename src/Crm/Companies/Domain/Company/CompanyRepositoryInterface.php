<?php

namespace Cuadrik\Crm\Companies\Domain\Company;


interface CompanyRepositoryInterface
{
    public function save(Company $user): void;
}