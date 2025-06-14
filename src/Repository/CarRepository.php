<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    // /**
    //  * @return Car[] Returns an array of Car objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Car
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    //order cars by model alphabetically
    public function findCarsOrderedByModel(string $make): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.make = :make')
            ->setParameter('make', $make)
            ->orderBy('c.model', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //order cars by travelled distance descending
    public function findCarsOrderedByTravelledDistanceDesc(string $make): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.make = :make')
            ->setParameter('make', $make)
            ->orderBy('c.travelledDistance', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //order cars by travelled distance ascending
    public function findCarsOrderedByTravelledDistanceAsc(string $make): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.make = :make')
            ->setParameter('make', $make)
            ->orderBy('c.travelledDistance', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //order cars with parts
    public function findCarWithParts(int $id): ?Car
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.parts', 'p')
            ->addSelect('p')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
