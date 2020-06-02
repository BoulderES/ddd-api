<?php


namespace Cuadrik\Crm\Companies\Application;


use Cuadrik\Crm\Companies\Domain\Company;
use Cuadrik\Crm\Companies\Domain\CompanyRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Model\CompanyId;
use Cuadrik\Crm\Shared\Domain\Model\Description;
use Cuadrik\Crm\Shared\Domain\Model\IsMain;

class CreateMainCompanyCommandHandler implements CreateMainCompanyInterface
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

    public function __invoke(CreateMainCompanyCommand $createCompanyCommand): void
    {
        $this->handle($createCompanyCommand);
    }

    public function handle(CreateMainCompanyCommand $createCompanyCommand)
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