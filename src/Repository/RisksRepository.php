<?php

namespace App\Repository;

use App\Entity\Risks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Risks|null find($id, $lockMode = null, $lockVersion = null)
 * @method Risks|null findOneBy(array $criteria, array $orderBy = null)
 * @method Risks[]    findAll()
 * @method Risks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RisksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Risks::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Risks $entity, bool $flush = true): void
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
    public function remove(Risks $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Filter the risks by their name
     * @param string $filter
     */
    public function filterByName(string $filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere("s.name LIKE '%$filter%'")
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Risks[] Returns an array of Risks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Risks
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
