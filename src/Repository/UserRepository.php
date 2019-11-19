<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function UsersPerFormation($id_formation)
        {
            $qb = $this->createQueryBuilder('u');
            $qb ->select('u')
                ->innerJoin('App\Entity\Participation', 'p', Join::WITH, 'u=p.id_user')
                ->innerJoin('App\Entity\Cycle', 'c', Join::WITH, 'c=p.id_Cycle and c=:id_formation')
                ->setParameter('id_formation', $id_formation);

            return $qb->getQuery()->getResult();
        }
}
