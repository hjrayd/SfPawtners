<?php

namespace App\Repository;

use App\Entity\Matche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Matche>
 */
class MatcheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matche::class);
    }

    public function findMatches( $userCats ): array {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder(); //Création d'une nouvelle instance du queryBuilder pour la requête DQL
           
        $qb ->select('m')
        
            ->from('App\Entity\Matche', 'm')
           
            ->where('m.catOne IN (:userCats) OR m.catTwo IN (:userCats)') 
            
   
            ->setParameter('userCats', $userCats);
    
          $query = $qb->getQuery();
          return $query->getResult(); 
    }

}
