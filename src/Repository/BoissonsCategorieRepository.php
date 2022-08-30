<?php

namespace App\Repository;

use App\Entity\BoissonsCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BoissonsCategorie>
 *
 * @method BoissonsCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoissonsCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoissonsCategorie[]    findAll()
 * @method BoissonsCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoissonsCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoissonsCategorie::class);
    }

    public function add(BoissonsCategorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BoissonsCategorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BoissonsCategorie[] Returns an array of BoissonsCategorie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BoissonsCategorie
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
