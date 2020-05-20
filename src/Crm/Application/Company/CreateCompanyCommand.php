<?php


namespace Cuadrik\Crm\Application\Company;


use Cuadrik\Crm\Domain\Shared\Model\CompanyId;
use Cuadrik\Crm\Domain\Shared\Model\Description;
use Cuadrik\Crm\Domain\Shared\Model\IsMain;

class CreateCompanyCommand
{
    private CompanyId $uuid;

    private Description $description;

    private IsMain $isMain;

    public function __construct(CompanyId $uuid, Description $description, IsMain $isMain)
    {
        $this->uuid = $uuid;
        $this->description = $description;
        $this->isMain = $isMain;

    }

    /**
     * @return CompanyId
     */
    public function getUuid(): CompanyId
    {
        return $this->uuid;
    }

    /**
     * @return Description
     */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /**
     * @return IsMain
     */
    public function getIsMain(): IsMain
    {
        return $this->isMain;
    }


}