<?php
declare(strict_types = 1);

namespace Cuadrik\Crm\Infrastructure\Repository\Doctrine;

use Cuadrik\Crm\Domain\User\User;
use Cuadrik\Crm\Domain\User\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findUserById(int $id): ?User
    {

    }

    public function userIdByToken(string $token): ?array
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u.id')
            ->where('u.token.value = :token')
            ->setParameter('token',$token)
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

    public function userByUuid(string $uuid): ?User
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.uuid.value = :uuid')
            ->setParameter('uuid',$uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $qb;

    }

    public function save(User $user): void
    {
        try {
            $this->_em->persist($user);
            $this->_em->flush();
        } catch (ORMException $e) {
            throw new Exception('Record not saved: ' . $e->getMessage());
        }
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
