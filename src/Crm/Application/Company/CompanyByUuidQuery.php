<?php


namespace Cuadrik\Crm\Application\Company;


use Cuadrik\Crm\Domain\Shared\Model\CompanyId;
use Cuadrik\Crm\Domain\Shared\Model\Description;

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