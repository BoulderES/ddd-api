<?php

namespace Cuadrik\Crm\Infrastructure\Repository\Doctrine;

use Cuadrik\Crm\Domain\Company\Company;
use Cuadrik\Crm\Domain\Company\CompanyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository implements CompanyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
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

    public function findCompanyById(int $id): ?Company
    {

    }

    public function findCompanyByUuid(string $uuid): ?Company
    {

    }

    public function save(Company $user): void
    {
        try {
            $this->_em->persist($user);
            $this->_em->flush();
        } catch (ORMException $e) {
            throw new Exception('Record not saved: ' . $e->getMessage());
        }
    }
}
