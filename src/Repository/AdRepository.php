<?php

namespace App\Repository;

use App\Entity\Ad;
use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    public function annonceGlobale() : array{

        return $this    ->createQueryBuilder('a')
            ->select('a.titre, a.prix')
            ->getQuery()
            ->getResult();
    }
    public function annonceById($id) : ?Ad {

        try {
            return $this->createQueryBuilder('a')
                ->where('a.id=:id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
        }
    }

    public function annonceByUser($idUser) : ?array {

        try {
            return $this->createQueryBuilder('a')
                ->where('a.user=:id')
                ->setParameter('id', $idUser)
                ->getQuery()
                ->getResult();
        } catch (NonUniqueResultException $e) {
        }
    }



    public function findAllOrderBy()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.dateCreation','DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function triParCate($categorie)
    {
        return $this->createQueryBuilder('a')
            ->where('a.categorie=:cate')
            ->setParameter('cate', $categorie)
            ->orderBy('a.dateCreation','DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function triParCateParUser($categorie,$id)
    {
        return $this->createQueryBuilder('a')
            ->where('a.categorie=:cate')
            ->andWhere('a.user=:id')
            ->setParameter('cate', $categorie)
            ->setParameter('id', $id)
            ->orderBy('a.dateCreation','DESC')
            ->getQuery()
            ->getResult()
            ;
    }


    public function nombreAnnonces($categorie) :?int
    {
        try {
            return $this->createQueryBuilder('a')
                ->select('count (a.id)')
                ->where('a.categorie=:cate')
                ->setParameter('cate', $categorie)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
        }
    }
    /*
    public function findOneBySomeField($value): ?Ad
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
