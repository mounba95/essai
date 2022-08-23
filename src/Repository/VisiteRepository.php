<?php

namespace App\Repository;

use App\Entity\Visite;
use App\Entity\Visiteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Visite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visite[]    findAll()
 * @method Visite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

    // /**
    //  * @return Visite[] Returns an array of Visite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Visite
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    //visite crere par un utilisateur
    public function vistesCreer()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('v' )
            ->from('App\Entity\Visite' ,'v')
            ->Where('v.statue = 1')
            ;
        ;
        return $query->getQuery()->getResult();
    }
//visite fermer par un utilisateur
    public function vistesFermer()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('v' )
            ->from('App\Entity\Visite' ,'v')
            ->Where('v.statue = 0')
            ;
        ;
        return $query->getQuery()->getResult();
    }

    //verification des visites encours par un visiteur
    public function verifictionVistesEncoucrour($telnumero)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('v' )
            ->from('App\Entity\Visite' ,'v')
            ->innerJoin('v.visiteurs', 'vt')
            ->Where('v.statue = 1 and vt.telVisiteur = :telvisiteur')
            ->setParameter('telvisiteur', $telnumero)
            ;
        ;
        return $query->getQuery()->getResult();
    }

//visite encour
    public function getVisiteEncour()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('count(v) as nombre' )
            ->from('App\Entity\Visite' ,'v')
            ->where('v.statue = 1')
        ;
        return $query->getQuery()->getResult();
    }

 //visite par jour
 public function getVisitebyJour($dateEntree)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
            ->select('count(v) as nombre')
            ->from('App\Entity\Visite' ,'v')
            ->where('v.dateOperation = :dateEntree')
            ->setParameter('dateEntree',$dateEntree)
        ;
        return $query->getQuery()->getResult();
    }



// visite par utilisateur
    public function getMesVisite($users)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('v')
            ->from('App\Entity\Visite' ,'v')
            ->innerJoin('v.users' , 'u')
            ->where('u.id = :users')
            ->setParameter('users',$users)
        ;
        return $query->getQuery()->getResult();
    }
    
    //Visites par période
    public function visitesParPeriode($dateEntree,$dateSortie)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('v')
            ->from('App\Entity\Visite' ,'v')
            ->where('v.entrer >= :dateEntree')
            ->andWhere('v.sortie <= :dateSortie')
            ->setParameter('dateEntree',$dateEntree)
            ->setParameter('dateSortie',$dateSortie)
        ;
        return $query->getQuery()->getResult();
    }

    //Visite par periode par service
    public function visitesParPeriodeParService($dateEntree, $dateSortie, $service)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('v')
            ->from('App\Entity\Visite' ,'v')
            ->leftJoin('v.services' , 's')
            ->where('s.id = :service')
            ->andWhere('v.entrer >= :dateEntree')
            ->andWhere('v.sortie <= :dateSortie')
            ->setParameter('service',$service)
            ->setParameter('dateEntree',$dateEntree)
            ->setParameter('dateSortie',$dateSortie)
        ;
        return $query->getQuery()->getResult();
    }


    //les visite par debut par service
     public function visitesParDebutParService($dateEntree, $service)
     {
         $queryBuilder = $this->getEntityManager()->createQueryBuilder();
         $query = $queryBuilder
         ->select('v')
             ->from('App\Entity\Visite' ,'v')
             ->leftJoin('v.services' , 's')
             ->where('s.id = :service')
             ->andWhere('v.entrer >= :dateEntree')
             ->setParameter('service',$service)
             ->setParameter('dateEntree',$dateEntree)
         ;
         return $query->getQuery()->getResult();
     }
      //les visite par debut par visiteur
    public function visitesParDebutParVisiteur($dateEntree, $visiteur)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('v')
            ->from('App\Entity\Visite' ,'v')
            ->leftJoin('v.visiteurs' , 'vt')
            ->where('vt.id = :visiteur')
            ->andWhere('v.entrer >= :dateEntree')
            ->setParameter('visiteur',$visiteur)
            ->setParameter('dateEntree',$dateEntree)
        ;
        return $query->getQuery()->getResult();
    }
 
    //visites par periode par visiteur
    public function visitesParPeriodeParVisiteur($dateEntree, $dateSortie, $visiteur)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('v')
            ->from('App\Entity\Visite' ,'v')
            ->leftJoin('v.visiteurs' , 'vt')
            ->where('vt.id = :visiteur')
            ->andWhere('v.entrer >= :dateEntree')
            ->andWhere('v.sortie <= :dateSortie')
            ->setParameter('visiteur',$visiteur)
            ->setParameter('dateEntree',$dateEntree)
            ->setParameter('dateSortie',$dateSortie)
        ;
        return $query->getQuery()->getResult();
    }

    //Visites par periode, service et visiteur 
    public function visitesParPeriodeParServiceParVisiteur($dateEntree, $dateSortie, $service, $visiteur)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('v')
            ->from('App\Entity\Visite' ,'v')
            ->leftJoin('v.users' , 'u')
            ->leftJoin('v.visiteurs' , 'vt')
            ->leftJoin('v.services' , 's')
            ->where('s.id = :service and vt.id = :visiteur')
            ->andWhere('v.entrer >= :dateEntree')
            ->andWhere('v.sortie <= :dateSortie')
            ->setParameter('service',$service)
            ->setParameter('visiteur',$visiteur)
            ->setParameter('dateEntree',$dateEntree)
            ->setParameter('dateSortie',$dateSortie)
        ;
        return $query->getQuery()->getResult();
    }

      //Visites par debut, service et visiteur 
      public function visitesParDebutParServiceParVisiteur($dateEntree, $service, $visiteur)
      {
          $queryBuilder = $this->getEntityManager()->createQueryBuilder();
          $query = $queryBuilder
          ->select('v')
              ->from('App\Entity\Visite' ,'v')
              ->leftJoin('v.visiteurs' , 'vt')
              ->leftJoin('v.services' , 's')
              ->where('s.id = :service and vt.id = :visiteur')
              ->andWhere('v.entrer >= :dateEntree')
              ->setParameter('service',$service)
              ->setParameter('visiteur',$visiteur)
              ->setParameter('dateEntree',$dateEntree)
          ;
          return $query->getQuery()->getResult();
      }
  

    // visite par visiteur et par service
    public function visitesParServiceParVisiteur( $service, $visiteur)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
        ->select('v')
            ->from('App\Entity\Visite' ,'v')
            ->leftJoin('v.users' , 'u')
            ->leftJoin('v.visiteurs' , 'vt')
            ->leftJoin('v.services' , 's')
            ->where('s.id = :service and vt.id = :visiteur')
            ->setParameter('service',$service)
            ->setParameter('visiteur',$visiteur)
        ;
        return $query->getQuery()->getResult();
    }

 // visite par visiteur 
public function visitesParVisiteur( $visiteur)
{
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $query = $queryBuilder
    ->select('v')
        ->from('App\Entity\Visite' ,'v')
        ->leftJoin('v.visiteurs' , 'vt')
        ->where('vt.id = :visiteur')
        ->setParameter('visiteur',$visiteur)
    ;
    return $query->getQuery()->getResult();
}


 // visite par serivce 
public function visitesParService( $service)
{
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $query = $queryBuilder
    ->select('v')
        ->from('App\Entity\Visite' ,'v')
        ->leftJoin('v.services' , 's')
        ->where('s.id = :service')
        ->setParameter('service',$service)
    ;
    return $query->getQuery()->getResult();
}

//visite depuit le debut
public function visitesParDebut($dateEntree)
{
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $query = $queryBuilder
    ->select('v')
        ->from('App\Entity\Visite' ,'v')
        ->Where('v.entrer >= :dateEntree')
        ->setParameter('dateEntree',$dateEntree)
    ;
    return $query->getQuery()->getResult();
}


// visite par service
public function getParService()
{
    $queryBuilder = $this->getEntityManager()->createQueryBuilder();
    $query = $queryBuilder
    ->select('count(v) as nombre', 's.description as service')
        ->from('App\Entity\Visite' ,'v')
        ->innerJoin('v.services' , 's')
        ->groupBy('s.id')
    ;
    return $query->getQuery()->getResult();
}



 //visite par type de visite
 public function visiteParType()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
            ->select('count(v) as nombre',' v.typeVisite as Type')
            ->from('App\Entity\Visite' ,'v')
           /*  ->where('v.dateOperation = :entrer')
            ->setParameter('entrer',new \Datetime(date('d-m-Y'))) */
            ->groupBy('v.typeVisite')
        ;
        return $query->getQuery()->getResult();
    }

}