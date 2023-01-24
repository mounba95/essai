<?php

namespace App\Repository;

use App\Entity\Rdv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rdv|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rdv|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rdv[]    findAll()
 * @method Rdv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RdvRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rdv::class);
    }

    // /**
    //  * @return Rdv[] Returns an array of Rdv objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rdv
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    
    //visite crer par un utilisateur
    public function rdvcrere()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('r' )
            ->from('App\Entity\Rdv' ,'r')
            ->Where('r.statut = 1')
            ;
        ;
        return $query->getQuery()->getResult();
    }

     //verification si un visiteur n'a pas de rendez vous la meme date
     public function verifictionVistesEncoucrour($daterdv,$users)
     {
         $queryBuilder = $this->getEntityManager()->createQueryBuilder();
         $query = $queryBuilder
         ->select('r' )
             ->from('App\Entity\Rdv' ,'r')
             ->innerJoin('r.users', 'u')
             ->Where('r.daterdv = :daterdv and u.telUser= :telUser')
             ->setParameter('daterdv', $daterdv)
             ->setParameter('telUser', $users)
             ;
         ;
         return $query->getQuery()->getResult();
     }

     //verification si un visiteur n'a pas de rendez vous la meme date
     public function verifictionVistesEncoucrours($daterdv,$service)
     {
         $queryBuilder = $this->getEntityManager()->createQueryBuilder();
         $query = $queryBuilder
         ->select('r' )
             ->from('App\Entity\Rdv' ,'r')
             ->innerJoin('r.services', 's')
             ->Where('r.daterdv = :daterdv and s.nomService= :nomService')
             ->setParameter('daterdv', $daterdv)
             ->setParameter('nomService', $service)
             ;
         ;
         return $query->getQuery()->getResult();
     }

     //Les rendez-vous annuler
    public function rdvFermer()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('r' )
            ->from('App\Entity\Rdv' ,'r')
            ->Where('r.statut = 0')
            ;
        ;
        return $query->getQuery()->getResult();
    }

    // Les rendez-vous personnel
    public function getMesRdv($user)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('r')
            ->from('App\Entity\Rdv' ,'r')
            ->innerJoin('r.users' , 'u')
            ->where('u.id = :users and r.statut=1')
            ->setParameter('users',$user)
        ;
        return $query->getQuery()->getResult();
    }


     //verification si un visiteur n'a pas de rendez vous la meme date
     public function verifierVisiteur($numvisiteur,$daterdv)
     {
         $queryBuilder = $this->getEntityManager()->createQueryBuilder();
         $query = $queryBuilder
         ->select('r' )
             ->from('App\Entity\Rdv' ,'r')
             ->innerJoin('r.visiteurs', 'v')
             ->Where('r.daterdv = :daterdv and v.telVisiteur = :telVisiteur')
             ->setParameter('telVisiteur', $numvisiteur)
             ->setParameter('daterdv', $daterdv)
             ;
         ;
         return $query->getQuery()->getResult();
     }

     //verification si un visiteur n'a pas de rendez vous la meme date
     public function verifierVisiteurs($numvisiteur,$daterdv)
     {
         $queryBuilder = $this->getEntityManager()->createQueryBuilder();
         $query = $queryBuilder
         ->select('r' )
             ->from('App\Entity\Rdv' ,'r')
             ->innerJoin('r.users', 'u')
             ->innerJoin('r.visiteurs', 'v')
             ->Where('r.daterdv = :daterdv and v.telVisiteur = :telVisiteur')
             ->setParameter('telVisiteur', $numvisiteur)
             ->setParameter('daterdv', $daterdv)
             ;
         ;
         return $query->getQuery()->getResult();
     }
}
