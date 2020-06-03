<?php

declare(strict_types = 1);


namespace Cuadrik\Crm\Users\Infrastructure\Repository\Doctrine;

use Cuadrik\Crm\Companies\Domain\Company;
use Cuadrik\Crm\Shared\Domain\Model\CompanyId;
use Cuadrik\Crm\Shared\Infrastructure\Symfony\DoctrineRepository;
use Cuadrik\Crm\Users\Domain\User;
use Cuadrik\Crm\Users\Domain\UserRepositoryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository  extends DoctrineRepository implements UserRepositoryInterface
{
    protected string $repository_class = User::class;

    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function findByCompanyId(CompanyId $companyId): ?User
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.companyId.value = :company_uuid')
            ->setParameter('company_uuid',$companyId->value())
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $qb;

//        $entityManager = $this->getEntityManager();
//
//        $query = $entityManager->createQuery('
//            SELECT c
//            FROM Cuadrik\Crm\Companies\Domain\Company c
//            WHERE c.uuid = :uuid
//        ')->setParameter('uuid',$companyId->value());
//
//        return $query->getOneOrNullResult();

    }

    public function userUuidByToken(string $token): ?array
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u.uuid')
            ->where('u.token.value = :token')
            ->setParameter('token',$token)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $qb;

    }

    public function userByUsername(string $username): ?User
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.username.value = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $qb;

    }

    public function userByToken(string $token): ?User
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.token.value = :token')
            ->setParameter('token',$token)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $qb;

    }

    public function userWithUuid(string $uuid): ?User
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.uuid = :uuid')
            ->setParameter('uuid',$uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $qb;

    }

    public function itemsPaginationQuery($paginatorOptions)
    {
        switch ($paginatorOptions['orderField'])
        {
            case 'userType':
                $paginatorOptions['orderField'] = 'ut.description';
                break;
            default:
                $paginatorOptions['orderField'] = 'u.'.$paginatorOptions['orderField'];
                break;
        }

        $query = $this->createQueryBuilder('u')
            ->leftJoin('u.userType','ut')
            ->where('u.isActive = true')
            ->orderBy($paginatorOptions['orderField'], $paginatorOptions['orderWay'])
            /*->setParameter('user',$paginatorOptions['user'])*/
        ;
        if('' !== $paginatorOptions['search']){
            $query
                ->andWhere('u.firstName LIKE :search OR u.lastName LIKE :search OR u.commercialName LIKE :search')
                ->setParameter('search',"%".$paginatorOptions['search']."%")
            ;
        }
        return $query;
    }

    public function enterprisesListsQuery($paginatorOptions)
    {
        switch ($paginatorOptions['orderField'])
        {
            case 'userType':
                $paginatorOptions['orderField'] = 'ut.description';
                break;
            default:
                $paginatorOptions['orderField'] = 'e.'.$paginatorOptions['orderField'];
                break;
        }

        $query = $this->createQueryBuilder('e')
            ->leftJoin('e.userType','ut')
            ->where('e.isActive = true')
            ->andWhere('ut.slug LIKE :slug')
            ->andWhere('e.commercialName is not null')
            ->andWhere('e.logo is not null')
            ->orderBy($paginatorOptions['orderField'], $paginatorOptions['orderWay'])
            /*->setParameter('user',$paginatorOptions['user'])*/
            ->setParameter('slug',"enterprise")
        ;
        if('' !== $paginatorOptions['search']){
            $query
                ->andWhere('e.firstName LIKE :search OR e.lastName LIKE :search OR e.commercialName LIKE :search')
                ->setParameter('search',"%".$paginatorOptions['search']."%")
            ;
        }
        return $query;
    }

    public function findFacebookUser($facebookId,$email)
    {
        return $this->createQueryBuilder('u')
            ->where('u.facebookId = :g')
            ->orWhere('u.email = :e')
            ->setParameter('g', $facebookId)
            ->setParameter('e', $email)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findGoogleUser($googleId,$email)
    {
        return $this->createQueryBuilder('u')
            ->where('u.googleId = :g')
            ->orWhere('u.email = :e')
            ->setParameter('g', $googleId)
            ->setParameter('e', $email)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}
