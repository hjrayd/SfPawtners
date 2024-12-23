<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findUserPseudo(string $pseudo) {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder('u'); 
    
        $qb->select('u') //on sélectionne les utilisateurs
            ->from('App\Entity\User', 'u'); 

            if (!empty($filter['pseudo'])) {
                $qb->andwhere('u.pseudo LIKE :pseudo')
                ->setParameter('pseudo', '%' . $filter['pseudo'] . '%');
            }
    
        $query = $qb->getQuery();

        return $query->getResult(); 

    }
}
