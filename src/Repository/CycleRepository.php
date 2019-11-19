<?php

namespace App\Repository;

use DateTime;
use App\Entity\Cycle;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Cycle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cycle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cycle[]    findAll()
 * @method Cycle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CycleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cycle::class);
    }

    public function FormationsPerUser($id_user)
    {
       $qb = $this->createQueryBuilder('f');
       $qb  ->select('f')
            ->innerJoin('App\Entity\Participation', 'p', Join::WITH, 'f=p.id_Cycle')
            ->innerJoin('App\Entity\User', 'u', Join::WITH, 'u=p.id_user and p.id_user=:id_user')
            ->setParameter('id_user', $id_user);   
       return $qb->getQuery()->getResult();
    }
    public function FormationsNoParticipe($id_user,$obj)
    {
       $today = new \DateTime();
       $qb1 = $this->createQueryBuilder('f');
       $formationParticipe = $qb1->select('f')
                                ->innerJoin('App\Entity\Participation', 'p', Join::WITH, 'f=p.id_Cycle')
                                ->where('f.dateDebut > :today and p.id_user = :id_user')
                                ->setParameters(['today'=> $today, 'id_user' => $id_user])
                                ->getQuery()->getResult();
        $qb2 = $obj->createQueryBuilder();
        $formations =        $qb2->select('form')
                                ->from('App\Entity\Cycle' , 'form')
                                ->where('form.dateDebut > :today')
                                ->setParameters(['today'=> $today])
                                ->getQuery()->getResult();
        $tab =[];
        foreach($formations as $NoPart)
        {
            $ok=true;   
            foreach($formationParticipe as $part)
            {
                if($NoPart->getId() == $part->getId())
                {
                        $ok =false;
                        break;
                } 
            }
            if($ok)
                    $tab[] = $NoPart;
        }

       return $tab ;
    }
    public function FormationsParticipe($id_user)
    {
       $today = new \DateTime();
       $qb1 = $this->createQueryBuilder('f');
       $formationParticipe = $qb1->select('f')
                                ->innerJoin('App\Entity\Participation', 'p', Join::WITH, 'f=p.id_Cycle')
                                ->where(' p.id_user = :id_user')
                                ->setParameters(['id_user' => $id_user])
                                ->getQuery()->getResult();
       return $formationParticipe ;
    }
}
