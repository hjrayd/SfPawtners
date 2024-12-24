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

        // dd(count($filters['breeds']));

        if (count($filters['breeds']) > 0) {
            $qb->leftJoin('c.breeds', 'b') //On joint la table Breed avec la table Cat équivalent d'un INNER JOIN
            ->andWhere('b.id IN (:breeds)')
            ->setParameter('breeds', $filters['breeds']);
        }

        if (count($filters['coats']) > 0) {
            $qb->leftJoin('c.coats', 'co') //On joint la table Breed avec la table Cat équivalent d'un INNER JOIN
            ->andWhere('co.id IN (:coats)')
            ->setParameter('coats', $filters['coats']);
        }

        if (!empty($filters['city'])) {
            $qb->andWhere('c.city LIKE :city')
            ->setParameter('city', '%' . $filters['city'] . '%');
        }

            
        if (isset($filters['ageMin'])) {
            $ageMinDate = (new \DateTime())->modify('-' . $filters['ageMin'] . ' years'); //On utilise la méthode modify pour plus de précision (mois et années)
                                                                                        //La méthode modify modifie l'objet dateTime
            $qb->andWhere('c.dateBirth <= :ageMin')
            ->setParameter('ageMin', $ageMinDate);
        }

        if (isset($filters['ageMax'])) {
            $ageMaxDate = (new \DateTime())->modify('-' . $filters['ageMax'] . ' years');
            $qb->andWhere('c.dateBirth >= :ageMax')
            ->setParameter('ageMax', $ageMaxDate);
        }

        // Exécution de la requête
        $query = $qb->getQuery();
        return $query->getResult();
    }
}
