<?php

declare(strict_types = 1);

namespace Cuadrik\Crm\Shared\Infrastructure\Symfony;

use Cuadrik\Crm\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Config\Definition\Exception\Exception;

abstract class DoctrineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->repository_class);
    }

    protected function entityManager(): EntityManager
    {
        return $this->_em;
    }

    protected function persist(AggregateRoot $entity): void
    {
        try{
            $this->entityManager()->persist($entity);
            $this->entityManager()->flush($entity);
        } catch (ORMException $e) {
            throw new Exception('Record not saved: ' . $e->getMessage());
        }

    }

    protected function remove(AggregateRoot $entity): void
    {
        try{
            $this->entityManager()->remove($entity);
            $this->entityManager()->flush($entity);
        } catch (ORMException $e) {
            throw new Exception('Record not saved: ' . $e->getMessage());
        }

    }

}
