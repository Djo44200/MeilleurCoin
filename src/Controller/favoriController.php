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

        // Récupération Requête de la barre de recherche
        $recherche = $request->query->get('search');

        if ($cate) {
            $listeFarori = $entityManager->getRepository('App:Ad')->triFavoriParCategorieParUser($cate,$this->getUser());
        }
        if (!$cate) {
            if (!$recherche) {

                $listeFarori = $entityManager->getRepository('App:Ad')->favoriParUser($this->getUser());
            }

            // Recherche d'une annonce
            if ($recherche){

                $listeFarori = $entityManager->getRepository('App:Ad')->actionRechercheParUserParFavori($recherche,$this->getUser());
            }
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
        $this->addFlash("success", "Modification du favori !");


        // Enregistrement dans la BDD
        $entityManager->persist($annonce);
        $entityManager->persist($user);
        $entityManager->flush();


        return $this->redirectToRoute('favori');
    }
}