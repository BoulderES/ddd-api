<?php


namespace Cuadrik\Backoffice\Companies\Application;


use Cuadrik\Shared\Domain\Model\CompanyId;
use Cuadrik\Shared\Domain\Model\Description;
use Cuadrik\Shared\Domain\Model\IsMain;

class CreateMainCompanyCommand
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