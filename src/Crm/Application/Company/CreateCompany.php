<?php


namespace Cuadrik\Crm\Application\Company;


use Cuadrik\Crm\Domain\Shared\Model\CompanyId;
use Cuadrik\Crm\Domain\Shared\Model\Description;
use Cuadrik\Crm\Domain\Shared\Model\IsMain;

class CreateCompany
{

    public function __invoke(CompanyId $uuid, Description $description = null, IsMain $isMain = null)
    {

    }
}