<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Message;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Message>
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    //Fonction pour retrouver tous les correspondants avec qui le user passé en paramètre a échangé
    public function findCorrespondents(User $user): array {

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder(); //Création du queryBuilder pourla requêteD DQL

        $qb = $sub; 

        $qb ->select('DISTINCT u') //On selectionne une seule fois le user
            ->from('App\Entity\User', 'u')
            ->innerJoin('App\Entity\Message', 'm', 'WITH', 'm.sender = u OR m.receiver = u')
            ->where('m.sender = :user OR m.receiver = :user') 
            ->setParameter('user', $user);
            
           
          $query = $sub->getQuery();
          return $query->getResult(); //On execute la requête et on retourne le résultat
    }
}
