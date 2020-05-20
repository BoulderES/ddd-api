<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Company;

use Cuadrik\Crm\Domain\Shared\Model\Locked;
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

    private CompanyId $uuid;

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
        return $this->uuid->value();
    }

    public function __construct(
        CompanyId $uuid,
        Description $description,
        IsMain $isMain,
        IsActive $isActive = null,
        Locked $locked = null,
        $parent = null
    )
    {
        if(!$isMain)
            $isMain = new IsMain(true);

        if(!$isActive)
            $isActive = new IsActive(true);

        if(!$locked)
            $locked = new Locked(false);

        if(!$description)
            $description = new Description(Description::MAIN_COMPANY_DESCRIPTION);

        parent::__construct($isMain, $isActive, $locked);

        $this->uuid         = $uuid;
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
        return $this->uuid->value();
    }

}