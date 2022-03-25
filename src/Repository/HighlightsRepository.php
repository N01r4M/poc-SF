<?php

namespace App\Repository;

use App\Entity\Highlights;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Highlights|null find($id, $lockMode = null, $lockVersion = null)
 * @method Highlights|null findOneBy(array $criteria, array $orderBy = null)
 * @method Highlights[]    findAll()
 * @method Highlights[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HighlightsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Highlights::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Highlights $entity, bool $flush = true): void
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
    public function remove(Highlights $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Filter the highlights by their name
     * @param string $filter
     */
    public function filterByName(string $filter)
    {
        return $this->createQueryBuilder('p')
            ->andWhere("p.name LIKE '%$filter%'")
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Highlights[] Returns an array of Highlights objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Highlights
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
