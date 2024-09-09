<?php

namespace App\Repository;

use App\Entity\Reclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reclamation>
 *
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }

    public function save(Reclamation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reclamation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getrec()
    {


        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT r.typeReclamation FROM App\Entity\Reclamation r'
        );

        $results = $query->getResult();
    }




    public function getTypes()
    {
        $qb = $this->createQueryBuilder('r')
            ->select('DISTINCT r.typeReclamation')
            ->getQuery()
            ->getResult();
        return $qb;
    }





    public function filterwithdiv($filters = null, $userId = null)
    {
        $qb = $this->createQueryBuilder('r');
        
        if ($filters != null) {
            $qb
                ->where('r.typeReclamation IN(:divs)')
                ->setParameter(':divs', array_values($filters));
        } else {
            $qb->select('r');
        }
        
        if ($userId != null) {
            $qb
                ->andWhere('r.idUser = :userId')
                ->setParameter(':userId', $userId);
        }
        
        return $qb->getQuery()->getResult();
    }
    



    public function TotalReclamation( $userId = null)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('COUNT(c)');
        if ($userId != null) {
            $qb
                ->Where('c.idUser = :idUser')
                ->setParameter('idUser', $userId);
        }
        return $qb->getQuery()->getSingleScalarResult();
    }
    

    //    /**
    //     * @return Reclamation[] Returns an array of Reclamation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reclamation
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
