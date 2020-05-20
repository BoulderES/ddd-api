<?php


namespace Cuadrik\Crm\Application\Company;


use Cuadrik\Crm\Domain\Company\Company;
use Cuadrik\Crm\Domain\Company\CompanyRepositoryInterface;
use Cuadrik\Crm\Domain\Shared\Model\CompanyId;
use Cuadrik\Crm\Domain\Shared\Model\Description;
use Cuadrik\Crm\Domain\Shared\Model\IsMain;

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
        if( !$company = $this->companyRepository->findOneBy(['uuid.value' => $createCompanyCommand->getUuid()]) ) {

            $this->createCompany->__invoke(
                new CompanyId($createCompanyCommand->getUuid()),
                new Description($createCompanyCommand->getDescription()),
                new IsMain(true)
            );

        }

    }
}