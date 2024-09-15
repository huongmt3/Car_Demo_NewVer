<?php

namespace App\Repository;

use App\Entity\Supplier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Supplier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Supplier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Supplier[]    findAll()
 * @method Supplier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supplier::class);
    }

    // /**
    //  * @return Supplier[] Returns an array of Supplier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Supplier
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // Get all local suppliers
    public function findLocalSuppliers()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.isImporter = :isImporter')  // Use camelCase here
            ->setParameter('isImporter', 0)  // Local suppliers have isImporter = 0
            ->getQuery()
            ->getResult();
    }
    
    // Get all importers
    public function findImporters()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.isImporter = :isImporter')  // Use camelCase here
            ->setParameter('isImporter', 1)  // Importers have isImporter = 1
            ->getQuery()
            ->getResult();
    }
}
