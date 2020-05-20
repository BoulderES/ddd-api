<?php


namespace Cuadrik\Crm\Application\Company;


use Cuadrik\Crm\Domain\Company\Company;
use Cuadrik\Crm\Domain\Company\CompanyRepositoryInterface;
use Cuadrik\Crm\Domain\Shared\Model\CompanyId;
use Cuadrik\Crm\Domain\Shared\Model\Description;
use Cuadrik\Crm\Domain\Shared\Model\IsMain;

class CompanyGetOrCreate
{
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(string $uuid): Company
    {
        $company = $this->companyRepository->byUuid($uuid);

        if(!$company) {

            $company = Company::createMainCompany(
                new CompanyId($uuid),
                new Description(Description::MAIN_COMPANY_DESCRIPTION),
                new IsMain(true)
            );

        }

        return $company;
    }
}