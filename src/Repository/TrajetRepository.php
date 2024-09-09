<?php

namespace App\Repository;

use App\Entity\Trajet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trajet>
 *
 * @method Trajet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trajet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trajet[]    findAll()
 * @method Trajet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrajetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trajet::class);
    }

    public function save(Trajet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trajet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Trajet[] Returns an array of Trajet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Trajet
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;





//    }




public function SortByvilleDepart(){
    return $this->createQueryBuilder('e')//alias bch t3awedh kelmet Evenement 
        ->orderBy('e.villeDepart','ASC')
        ->getQuery()
        ->getResult()
        ;
}
public function SortByvilleDarrive()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.villeDarrive','ASC')
        ->getQuery()
        ->getResult()
        ;
}
public function SortBymodePaiement()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.modePaiement','ASC')
        ->getQuery()
        ->getResult()
        ;
}








public function findByvilleDepart( $villeDepart)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.villeDepart LIKE :villeDepart')
        ->setParameter('villeDepart','%' .$villeDepart. '%')
        ->getQuery()
        ->execute();
}
public function findByvilleDarrive( $villeDarrive)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.villeDarrive LIKE :villeDarrive')
        ->setParameter('villeDarrive','%' .$villeDarrive. '%')
        ->getQuery()
        ->execute();
}
public function findBymodePaiement( $modePaiement)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.modePaiement LIKE :modePaiement')
        ->setParameter('modePaiement','%' .$modePaiement. '%')
        ->getQuery()
        ->execute();
}




// client
public function findByvilleDepartc( $villeDepart)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.villeDepart LIKE :villeDepart')
        ->setParameter('villeDepart','%' .$villeDepart. '%')
        ->getQuery()
        ->execute();
}
public function findByvilleDarrivec( $villeDarrive)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.villeDarrive LIKE :villeDarrive')
        ->setParameter('villeDarrive','%' .$villeDarrive. '%')
        ->getQuery()
        ->execute();
}
public function findBymodePaiementc( $modePaiement)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.modePaiement LIKE :modePaiement')
        ->setParameter('modePaiement','%' .$modePaiement. '%')
        ->getQuery()
        ->execute();
}


public function countdarrivee()
{
$qb = $this->createQueryBuilder('p')
            ->select('COUNT(p.villeDarrive)');

        return $qb->getQuery()->getSingleScalarResult();
}
public function countdarrive(): array
{
    $qb = $this->createQueryBuilder('d')
        ->select('d.villeDarrive as villeDarrive, COUNT(DISTINCT d.idTrajet) as count')
        ->groupBy('d.villeDarrive')
        ->getQuery();

    return $qb->getResult();
}
}