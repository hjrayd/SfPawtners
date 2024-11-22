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
            //On selectionne une seule fois le user
        $qb ->select('m')
            //On crée l'alias et on précise qu'on veut l'objet user de l'entité User
            ->from('App\Entity\Matche', 'm')
            //On filtre les résultat de la requête finale en n'affichant que les messages si le user et expediteur ou receveur
            ->where('m.catOne IN (:userCats) OR m.catTwo IN (:userCats)') 
            
            //On associe la valeur a user passé en paramètre + protection contre injection SQL
            ->setParameter('userCats', $userCats);
    
          $query = $qb->getQuery();
          return $query->getResult(); //On execute la requête et on retourne le résultat
    }

}
