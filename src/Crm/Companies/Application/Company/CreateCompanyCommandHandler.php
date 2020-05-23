<?php


namespace Cuadrik\Crm\Companies\Application\Company;


use Cuadrik\Crm\Companies\Domain\Company\Company;
use Cuadrik\Crm\Companies\Domain\Company\CompanyRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Model\CompanyId;
use Cuadrik\Crm\Shared\Domain\Model\Description;
use Cuadrik\Crm\Shared\Domain\Model\IsMain;

class CreateCompanyCommandHandler
{
    private CompanyRepositoryInterface $companyRepository;
    private CreateCompany $createCompany;

    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        CreateCompany $createCompany
    )
    {
        $this->companyRepository = $companyRepository;
        $this->createCompany = $createCompany;
    }

    public function __invoke(CreateCompanyCommand $createCompanyCommand)
    {
        if( !$company = $this->companyRepository->findOneBy(['uuid' => $createCompanyCommand->getUuid()]) ) {

            $this->createCompany->__invoke(
                new CompanyId($createCompanyCommand->getUuid()),
                new Description($createCompanyCommand->getDescription()),
                new IsMain(true)
            );

        }

    }
}