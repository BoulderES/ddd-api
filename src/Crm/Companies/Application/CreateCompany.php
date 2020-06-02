<?php


namespace Cuadrik\Crm\Companies\Application;


use Cuadrik\Crm\Shared\Domain\Model\CompanyId;
use Cuadrik\Crm\Shared\Domain\Model\Description;
use Cuadrik\Crm\Shared\Domain\Model\IsMain;

class CreateCompany
{

    public function __invoke(CompanyId $uuid, Description $description = null, IsMain $isMain = null)
    {

    }
}