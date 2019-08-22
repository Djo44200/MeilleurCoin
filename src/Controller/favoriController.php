<?php


namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class favoriController extends Controller
{


    /**
     * @Route ("favori",name="favori")
     *
     */
    public function mesFavori(EntityManagerInterface $entityManager, Request $request)
    {



        $cate = $request->query->get('cate');
        //  Avoir la liste des catégories
        $listeCate = $entityManager->getRepository('App:Categorie')->findAll();

        if ($cate) {
            $listeFarori = $entityManager->getRepository('App:Ad')->triFavoriParCategorieParUser($cate,$this->getUser());
        }
        if (!$cate) {

            $listeFarori = $entityManager->getRepository('App:Ad') ->favoriParUser($this->getUser());
        }


        return $this->render('favori/mesFavoris.html.twig', ["tableauFavori" => $listeFarori, "tableauCate" =>$listeCate]);
    }

    /**
     * @Route ("ajoutFavori",name="ajoutFavori")
     *
     */

    public function ajouterAuFavori(EntityManagerInterface $entityManager, Request $request)
    {


        $annonce =$entityManager->getRepository('App:Ad') ->find($request->query->get('id'));
        $user = $entityManager->getRepository('App:User') ->find($this->getUser());
        $annonce -> addUser($user);
        $user -> addAds($annonce);

        // Message de confirmation
        $this->addFlash("success", "Favori sauvegardé !");


        // Enregistrement dans la BDD
        $entityManager->persist($annonce);
        $entityManager->persist($user);
        $entityManager->flush();


        return $this->render('Accueil/accueil.html.twig');
    }
}