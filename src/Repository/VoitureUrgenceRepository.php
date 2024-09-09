<?php

namespace App\Repository;

use App\Entity\VoitureUrgence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VoitureUrgence>
 *
 * @method VoitureUrgence|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoitureUrgence|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoitureUrgence[]    findAll()
 * @method VoitureUrgence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoitureUrgenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VoitureUrgence::class);
    }

    public function findVoitureUrgence(int $page ,int $limit = 3 ):array
    {
        $limit = abs($limit);
        $result = [];

        $query = $this->createQueryBuilder('entity')
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit)
            ->getQuery();

        //$results = $query->getResult();

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        if (empty($data)){
            return $result;
        }

        $pages =ceil($paginator->count()/$limit);

        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;

        return $result;
    }
    public function save(VoitureUrgence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VoitureUrgence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return VoitureUrgence[] Returns an array of VoitureUrgence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VoitureUrgence
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
