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
    // Toutes les annonces
    public function annonceGlobale() : array{

        return $this    ->createQueryBuilder('a')
            ->select('a.titre, a.prix')
            ->getQuery()
            ->getResult();
    }

    // Afficher les détails d'une annonce
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
    // Afficher mes annonces
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


    // Recherche toutes annonces
    public function findAllOrderBy()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.dateCreation','DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    // Tri de toutes les annonces par catégories
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
    // Tri de mes annonces par catégorie
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

    // Tri des favoris par catégorie et par user
    public function triFavoriParCategorieParUser($categorie,$user)
    {

        return $this->createQueryBuilder('a')
            ->where('a.categorie=:cate')
            ->setParameter('cate', $categorie)
            ->andWhere(':user MEMBER OF a.users')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

    }
    // Affichage de mes favoris
    public function favoriParUser($user)
    {

            return $this->createQueryBuilder('a')
                ->where(':user MEMBER OF a.users')
                ->setParameter('user', $user)
                ->getQuery()
                ->getResult();

    }


    // Recherche sur toutes les annonces
    public function actionRecherche($data){

        return $this->createQueryBuilder('a')
            ->where('a.titre LIKE :data')
            ->setParameter('data', '%'.$data.'%')
            ->getQuery()
            ->getResult();

    }

    // Recherches sur les annonces d'un user
    public function actionRechercheParUser($data,$user){

        return $this->createQueryBuilder('a')
            ->where('a.titre LIKE :data')
            ->setParameter('data', '%'.$data.'%')
            ->andWhere('a.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

    }

    // Recherches sur les favoris d'un user
    public function actionRechercheParUserParFavori($data,$user){


        return $this->createQueryBuilder('a')
            ->where(':user MEMBER OF a.users')
            ->setParameter('user', $user)
            ->AndWhere('a.titre LIKE :data')
            ->setParameter('data', '%'.$data.'%')
            ->getQuery()
            ->getResult();

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
