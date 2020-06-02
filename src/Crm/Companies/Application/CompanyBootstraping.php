<?php


namespace Cuadrik\Crm\Companies\Application;


use Cuadrik\Crm\Companies\Domain\Company;
use Cuadrik\Crm\Companies\Domain\CompanyRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Model\CompanyId;
use Cuadrik\Crm\Shared\Domain\Model\Description;
use Cuadrik\Crm\Shared\Domain\Model\IsMain;

class CompanyBootstraping
{
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(CompanyId $companyId): void
    {
        $this->handle($companyId);
    }

    public function handle(CompanyId $companyId): void
    {
        $company = $this->companyRepository->byUuid($companyId->value());

        if(!$company) {

            $company = Company::createMainCompany(
                $companyId,
                new Description(Description::MAIN_COMPANY_DESCRIPTION),
                new IsMain(true)
            );

        }

        $this->companyRepository->save($company);
    }
}