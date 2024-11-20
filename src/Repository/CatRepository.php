<?php

namespace App\Repository;

use App\Entity\Cat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cat>
 */
class CatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cat::class);
    }

    public function findByFilters(array $filters)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder('c'); //Création d'une nouvelle instance du queryBuilder pour la requête DQL
        $qb->select('c')
            ->from('App\Entity\Cat', 'c');

        if (!empty($filters['breeds'])) {
            $qb->join('c.breeds', 'b') //On joint la table Breed avec la table Cat équivalent d'un INNER JOIN
            ->andwhere('b.id IN (:breeds)')
            ->setParameter('breeds', $filters['breeds']);
        }

        if (!empty($filters['coat'])) {
            $qb->andwhere('c.coat LIKE :coat')
            ->setParameter('coat', '%' . $filters['coat'] . '%'); //nous permet de trouver la couleur même si elle est précéder ou succèder par un autre mot
        }

        if (!empty($filters['city'])) {
            $qb->andwhere('c.city LIKE :city')
            ->setParameter('city', '%' . $filters['city'] . '%');
        }

        $query = $qb->getQuery();
        $cats = $query->getResult();
        
        if (isset($filters['ageMin']) || isset($filters['ageMax'])) {
            $cats = array_filter($cats, function($cat) use ($filters) {
                $age = $cat->getAge(); // On utilise notre méthode getAge dans notre entité Cat
                return ($age >= $filters['ageMin'] && $age <= $filters['ageMax']);
            });
        }
    
        return $cats;


    }
}
