<?php

namespace App\Repository;

use App\Entity\Urgence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Urgence>
 *
 * @method Urgence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Urgence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Urgence[]    findAll()
 * @method Urgence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrgenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Urgence::class);
    }

    /**
     * @return Urgence[]
     */
    /*public function findAllUrgences(?String $parameter,?String $parameter1,?String $parameter2): array
    {
        //$qb = $this->getEntityManager()->createQueryBuilder();
        return $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\Urgence', 'u')
            ->where('u.statuts IN (:param1, :param2, :param3)')
            ->setParameters(['param1' => $parameter, 'param2' => $parameter1, 'param3' => $parameter2])
            ->getQuery()
            ->getResult();
    }
    */

    public function findAllUrgences(?string $parameter, ?string $parameter1, ?string $parameter2): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\Urgence', 'u');

        if ($parameter !== null && $parameter1 !== null && $parameter2 !== null) {
            $qb->where('u.statuts IN (:param1, :param2, :param3)')
                ->setParameters(['param1' => $parameter, 'param2' => $parameter1, 'param3' => $parameter2]);
        }

        return $qb->getQuery()->getResult();
    }


    public function save(Urgence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Urgence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Urgence[] Returns an array of Urgence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Urgence
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
