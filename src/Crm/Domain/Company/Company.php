<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Company;

use Cuadrik\Crm\Domain\Shared\Model\IsLocked;
use Cuadrik\Crm\Domain\Shared\Aggregate\AggregateRoot;
use Cuadrik\Crm\Domain\Shared\Model\CompanyId;
use Cuadrik\Crm\Domain\Shared\Model\Description;
use Cuadrik\Crm\Domain\Shared\Model\IsActive;
use Cuadrik\Crm\Domain\Shared\Model\IsMain;
use Cuadrik\Crm\Domain\Shared\Model\UserId;

use Doctrine\ORM\Mapping as ORM;

class Company extends AggregateRoot
{

    private $users;

    private string $uuid;

    private int $invoiceNumeratorDebit;

    private string $invoiceNumeratorDebitPrefix;

    private int $invoiceNumeratorCredit;

    private string $invoiceNumeratorCreditPrefix;

    private int $numberOfPhones;

    private int $numberOfAddresses;

    private int $numberOfBankAccounts;

    private string $parent;

//    private UserId $userId;

    public function __toString()
    {
        return $this->uuid;
    }

    public function __construct(
        CompanyId $uuid,
        Description $description,
        IsMain $isMain = null,
        IsActive $isActive = null,
        IsLocked $isLocked = null,
        $parent = null
    )
    {
        if(!$isMain)
            $isMain = IsMain::fromBool(true);

        if(!$isActive)
            $isActive = IsActive::fromBool(true);

        if(!$isLocked)
            $isLocked = IsLocked::fromBool(false);

        if(!$description)
            $description = Description::fromString(Description::MAIN_COMPANY_DESCRIPTION);

        parent::__construct($isMain, $isActive, $isLocked);

        $this->uuid         = $uuid->value();
        $this->description  = $description->value();
        $this->users        = new \Doctrine\Common\Collections\ArrayCollection();


        $this->invoiceNumeratorDebit        = 0;
        $this->invoiceNumeratorDebitPrefix  = "CC";
        $this->invoiceNumeratorCredit       = 0;
        $this->invoiceNumeratorCreditPrefix = "AA";
        $this->numberOfPhones               = 1;
        $this->numberOfAddresses            = 1;
        $this->numberOfBankAccounts         = 1;
//        $this->parent = $this;
    }

    public function users()
    {
        return $this->users;
    }

    public static function createMainCompany(CompanyId $companyId, Description $description, IsMain $isMain)
    {
        return new self($companyId, $description, $isMain);

    }

    public function resetInvoiceNumerators()
    {
        $this->invoiceNumeratorDebit    = 0;
        $this->invoiceNumeratorCredit   = 0;

        return $this;
    }

    public function uuid()
    {
        return $this->uuid;
    }

}