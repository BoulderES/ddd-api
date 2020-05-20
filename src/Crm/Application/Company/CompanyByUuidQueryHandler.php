<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Application\Company;


use Cuadrik\Crm\Domain\Company\CompanyRepositoryInterface;
use Cuadrik\Crm\Domain\Shared\Bus\Query\QueryHandler;
use Cuadrik\Crm\Domain\Shared\Model\UserId;
use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\BadRequestException;
use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\UnauthorizedException;
use Cuadrik\Crm\Domain\User\Password;
use Cuadrik\Crm\Domain\User\Username;

class CompanyByUuidQueryHandler implements QueryHandler
{

    private CompanyRepositoryInterface $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(CompanyByUuidQuery $companyByUuidQuery)
    {
        $company = $this->companyRepository->findOneBy(['uuid.value' => $companyByUuidQuery->getUuid()]);

        if(!$company)
            BadRequestException::throw('User not found! ' . get_called_class());

        return $company;

    }

}