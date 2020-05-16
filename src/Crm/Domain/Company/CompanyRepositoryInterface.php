<?php

namespace Cuadrik\Crm\Domain\Company;


interface CompanyRepositoryInterface
{
    public function save(Company $user): void;
}