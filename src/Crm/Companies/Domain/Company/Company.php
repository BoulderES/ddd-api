<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Domain\Company;

use Cuadrik\Crm\Shared\Domain\Model\IsLocked;
use Cuadrik\Crm\Shared\Domain\Aggregate\AggregateRoot;
use Cuadrik\Crm\Shared\Domain\Model\CompanyId;
use Cuadrik\Crm\Shared\Domain\Model\Description;
use Cuadrik\Crm\Shared\Domain\Model\IsActive;
use Cuadrik\Crm\Shared\Domain\Model\IsMain;
use Cuadrik\Crm\Shared\Domain\Model\UserId;

use Doctrine\ORM\Mapping as ORM;

class Company extends AggregateRoot
{

    private $users;

    private string $uuid;

    private InvoiceNumeratorDebit $invoiceNumeratorDebit;

    private InvoiceNumeratorDebitPrefix $invoiceNumeratorDebitPrefix;

    private InvoiceNumeratorCredit $invoiceNumeratorCredit;

    private InvoiceNumeratorCreditPrefix $invoiceNumeratorCreditPrefix;

    private NumberOfPhones $numberOfPhones;

    private NumberOfAddresses $numberOfAddresses;

    private NumberOfBankAccounts $numberOfBankAccounts;

    private Company $parent;

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
        $this->description  = $description;
        $this->users        = new \Doctrine\Common\Collections\ArrayCollection();


        $this->invoiceNumeratorDebit        = new InvoiceNumeratorDebit(0);
        $this->invoiceNumeratorDebitPrefix  = new InvoiceNumeratorDebitPrefix("CC");
        $this->invoiceNumeratorCredit       = new InvoiceNumeratorCredit(0);
        $this->invoiceNumeratorCreditPrefix = new InvoiceNumeratorCreditPrefix("AA");
        $this->numberOfPhones               = new NumberOfPhones(1);
        $this->numberOfAddresses            = new NumberOfAddresses(1);
        $this->numberOfBankAccounts         = new NumberOfBankAccounts(1);
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
        $this->invoiceNumeratorDebit = new InvoiceNumeratorDebit(0);
        $this->invoiceNumeratorCredit = new InvoiceNumeratorCredit(0);

        return $this;
    }

    public function uuid()
    {
        return $this->uuid;
    }

}