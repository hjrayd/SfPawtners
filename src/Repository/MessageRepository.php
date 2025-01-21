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
        $sub = $em->createQueryBuilder(); //Création du queryBuilder pour la requête DQL

        $qb = $sub; 

            //On selectionne une seule fois le user
        $qb ->select('DISTINCT u')

            //On crée l'alias et on précise qu'on veut l'objet user de l'entité User
            ->from('App\Entity\User', 'u')

            //On joint les deux tables User et Message seulement là ou User est expéditeur ou receveur
            ->join('App\Entity\Message', 'm', 'WITH', 'm.sender = u OR m.receiver = u') //With permet de poser une condition
                                                                                         
            //On filtre les résultat de la requête finale en n'affichant que les utilisateurs si le user et expediteur ou receveur
            ->where('m.sender = :user OR m.receiver = :user') 
            ->andWhere('u.id != :user')
            //On associe la valeur a user passé en paramètre + protection contre injection SQL
            ->setParameter('user', $user);
    
          $query = $sub->getQuery();
          return $query->getResult(); //On execute la requête et on retourne le résultat
    }


    //Fonction pour retrouver tous les messages
    public function findAllMessages(User $user, User $receiver): array {

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder(); //Création du queryBuilder pourla requêteD DQL

        $qb = $sub; 

            //On selectione tous les messages
        $qb ->select('m')
            ->from('App\Entity\Message', 'm')

            //On joint les table User et Message 
            ->innerJoin('m.sender', 'sender')
            ->innerJoin('m.receiver', 'receiver')

            //Là où notre :user est receiver et $id = sender OU :user = sender et $id = receiver
            ->where('
            (m.sender = :user AND m.receiver = :receiver)
            OR (m.sender = :receiver AND m.receiver = :user)
        ')

            //On associe les valeurs aux paramètres user et receiver + protection contre injection SQL
            ->setParameter('user', $user)
            ->setParameter('receiver', $receiver)

            //Tri des messages par ordre croissant pour avoir les plus récents en bas
            ->orderby('m.messageDate', 'ASC');
    
          $query = $sub->getQuery();
          return $query->getResult(); //On execute la requête et on retourne le résultat
    }
    

    //Fonction pour savoir si deux utilisateurs ont déjà échangés
    public function findIfMessageExchanged (User $user1, User $user2) {
        $messagesExchanged1 = $this->findBy([
            'sender' => $user1,
            'receiver' => $user2
        ]);

        if(!empty($messagesExchanged1)) {
            return true;
        }

        $messagesExchanged2 = $this->findBy([
            'sender' => $user2,
            'receiver' => $user1
        ]);

        if(!empty($messagesExchanged2)) {
            return true;
        }
        
        return false;
    }


    
}
