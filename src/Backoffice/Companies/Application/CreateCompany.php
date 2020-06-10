<?php


namespace Cuadrik\Backoffice\Companies\Application;


use Cuadrik\Shared\Domain\Model\CompanyId;
use Cuadrik\Shared\Domain\Model\Description;
use Cuadrik\Shared\Domain\Model\IsMain;

class CreateCompany
{

    public function __invoke(CompanyId $uuid, Description $description = null, IsMain $isMain = null)
    {

    }
}