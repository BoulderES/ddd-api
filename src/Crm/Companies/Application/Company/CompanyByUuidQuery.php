<?php


namespace Cuadrik\Crm\Companies\Application\Company;


use Cuadrik\Crm\Shared\Domain\Model\CompanyId;
use Cuadrik\Crm\Shared\Domain\Model\Description;

class CompanyByUuidQuery
{
    private CompanyId $uuid;

    public function __construct(CompanyId $uuid)
    {
        $this->uuid = $uuid;

    }

    /**
     * @return CompanyId
     */
    public function getUuid(): CompanyId
    {
        return $this->uuid;
    }

}