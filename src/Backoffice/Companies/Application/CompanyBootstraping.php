<?php


namespace Cuadrik\Backoffice\Companies\Application;


use Cuadrik\Backoffice\Companies\Domain\Company;
use Cuadrik\Backoffice\Companies\Domain\CompanyRepositoryInterface;
use Cuadrik\Shared\Domain\Model\CompanyId;
use Cuadrik\Shared\Domain\Model\Description;
use Cuadrik\Shared\Domain\Model\IsMain;

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