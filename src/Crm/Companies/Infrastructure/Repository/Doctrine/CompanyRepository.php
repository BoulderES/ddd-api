<?php

namespace Cuadrik\Crm\Companies\Infrastructure\Repository\Doctrine;

use Cuadrik\Crm\Companies\Domain\Company;
use Cuadrik\Crm\Companies\Domain\CompanyRepositoryInterface;
use Cuadrik\Crm\Shared\Infrastructure\Persistence\DoctrineRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends DoctrineRepository implements CompanyRepositoryInterface
{
    protected string $repository_class = Company::class;

    public function save(Company $company): void
    {
        $this->persist($company);
    }

    public function findMainCompany()
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.id')
            ->where('c.isMain = true')
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $qb;

    }

    public function byUuid(string $uuid): ?Company
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.uuid = :uuid')
            ->setParameter('uuid',$uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $qb;

    }

    public function findCompanyById(int $id): ?Company
    {

    }

    public function findCompanyByUuid(string $uuid): ?Company
    {

    }

}
