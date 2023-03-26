<?php

namespace App\Repository;

use App\Entity\Medicals;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Medicals>
 *
 * @method Medicals|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medicals|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medicals[]    findAll()
 * @method Medicals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicalsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medicals::class);
    }

    public function save(Medicals $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Medicals $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getAllMedicals() {
        $repository = $this->getEntityManager()->getRepository(Medicals::class);
        $products = $repository->findAll();
        return $products;
    }

//    /**
//     * @return Medicals[] Returns an array of Medicals objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Medicals
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
