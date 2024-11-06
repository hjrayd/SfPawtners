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

            //On selectionne une seule fois le user
        $qb ->select('DISTINCT u')

            //On crée l'alias et on précise qu'on veut l'objet user de l'entité User
            ->from('App\Entity\User', 'u')

            //On joint les deux deux tables User et Message seulement là ou User et expsditeur ou receveur
            ->innerJoin('App\Entity\Message', 'm', 'WITH', 'm.sender = u OR m.receiver = u')

            //On filtre les résultat de la requête finale en n'affichant que les messages si le user et expediteur ou receveur
            ->where('m.sender = :user OR m.receiver = :user') 

            //On associe la valeur a user passé en paramètre + protection contre injection SQL
            ->setParameter('user', $user);
    
          $query = $sub->getQuery();
          return $query->getResult(); //On execute la requête et on retourne le résultat
    }


    //Fonction pour retrouver tous les messages
    public function findAllMessages(User $user): array {

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder(); //Création du queryBuilder pourla requêteD DQL

        $qb = $sub; 

            //On selectionne une seule fois le user
        $qb ->select('DISTINCT m')

            //On crée l'alias et on précise qu'on veut l'objet user de l'entité User
            ->from('App\Entity\Message', 'm')

            //On joint les deux deux tables User et Message seulement là ou User et expsditeur ou receveur
            ->innerJoin('m.sender', 'sender')
            ->innerJoin('m.receiver', 'receiver')

            //On filtre les résultat de la requête finale en n'affichant que les messages si le user et expediteur ou receveur
            ->where('m.sender = :user OR m.receiver = :user') 

            //On associe la valeur a user passé en paramètre + protection contre injection SQL
            ->setParameter('user', $user)

            ->orderby('m.messageDate', 'ASC');
    
          $query = $sub->getQuery();
          return $query->getResult(); //On execute la requête et on retourne le résultat
    }
}
