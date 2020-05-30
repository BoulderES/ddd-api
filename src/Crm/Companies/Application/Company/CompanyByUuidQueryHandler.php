<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Application\Company;


use Cuadrik\Crm\Companies\Domain\Company\CompanyRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Bus\Query\QueryHandler;
use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;

class CompanyByUuidQueryHandler implements QueryHandler
{

    private CompanyRepositoryInterface $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(CompanyByUuidQuery $companyByUuidQuery): void
    {
        $this->handle($companyByUuidQuery);
    }

    public function handle(CompanyByUuidQuery $companyByUuidQuery)
    {
        $company = $this->companyRepository->findOneBy(['uuid' => $companyByUuidQuery->getUuid()]);

        if(!$company)
            ExceptionManager::throw('User not found! ' . get_called_class());

        return $company;

    }

}