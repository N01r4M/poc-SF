<?php

namespace App\Repository;

use App\Entity\Phases;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Phases|null find($id, $lockMode = null, $lockVersion = null)
 * @method Phases|null findOneBy(array $criteria, array $orderBy = null)
 * @method Phases[]    findAll()
 * @method Phases[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhasesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Phases::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Phases $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Phases $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Filter the phases by their name
     * @param string $filter
     */
    public function filterByName(string $filter)
    {
        return $this->createQueryBuilder('p')
            ->andWhere("p.name LIKE '%$filter%'")
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Phases[] Returns an array of Phases objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Phases
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
