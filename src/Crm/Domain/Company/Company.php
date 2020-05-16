<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Company;

use Cuadrik\Crm\Domain\Shared\Aggregate\AggregateRoot;
use Cuadrik\Crm\Domain\Shared\Model\CompanyId;
use Cuadrik\Crm\Domain\Shared\Model\IsMain;
use Cuadrik\Crm\Domain\Shared\Model\UserId;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="companies")
 */
class Company extends AggregateRoot
{
    const MAIN_COMPANY_DESCRIPTION = "Main";

    private $users;

    private CompanyId $uuid;

    private $invoiceNumeratorDebit;

    private $invoicePrefixNumeratorDebit;

    private $invoiceNumeratorCredit;

    private $invoicePrefixNumeratorCredit;

    private $numberOfPhones;

    private $numberOfAddresses;

    private $numberOfBankAccounts;

    private Company $parent;

    private UserId $userId;

    public function __toString()
    {
        return $this->uuid->value();
    }

    public function __construct(
        CompanyId $uuid,
        IsMain $isMain,
        $description = self::MAIN_COMPANY_DESCRIPTION,
        $parent = null
    )
    {
        parent::__construct($isMain, );

        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->uuid = $uuid;
        $this->description = $description;
//        $this->slug = Slugify::create($description);

        $this->invoiceNumeratorDebit = 0;
        $this->invoicePrefixNumeratorDebit = "CC";
        $this->invoiceNumeratorCredit = 0;
        $this->invoicePrefixNumeratorCredit = "AA";
        $this->numberOfPhones = 1;
        $this->numberOfAddresses = 1;
        $this->numberOfBankAccounts = 1;
//        $this->parent = $this;
    }

    public function users()
    {
        return $this->users;
    }

    public static function create(CompanyId $companyId, IsMain $isMain)
    {
        return new self($companyId, $isMain);

    }

    public function resetInvoiceNumerators()
    {
        $this->invoiceNumeratorDebit = 0;
        $this->invoiceNumeratorCredit = 0;

        return $this;
    }

    public function uuid()
    {
        return $this->uuid;
    }

}