<?php


namespace App\Controller;


use App\Entity\Ad;
use App\Form\AdType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AnnonceController
 * @package App\Controller
 * @Route("/annonce/")
 */

class AnnonceController extends Controller
{

    /**
     * @Route ("search",name="recherche")
     *
     */
    public function annonces(EntityManagerInterface $entityManager, Request $request)
    {
        // Récupération de l'id de la catégorie
        $cate = $request->query->get('cate');

        //  Avoir la liste des catégories
        $listeCate = $entityManager->getRepository('App:Categorie')->findAll();

        // Récupération Requête de la barre de recherche
        $recherche = $request->query->get('search');


        // Si id existe alors affichage des données dans un tableau
        if ($cate) {
            $req = $entityManager->getRepository('App:Ad')->triParCate($cate);
        }
        if (!$cate) {
            if (!$recherche) {
                $req = $entityManager->getRepository('App:Ad')->findAllOrderBy();
            }

            // Recherche d'une annonce
            if ($recherche){

                $req = $entityManager->getRepository('App:Ad')->actionRecherche($recherche);
            }

        }
        return $this->render('Annonce/listeAnnonce.html.twig', ["tableauAnnonce" => $req, "tableauCate" =>$listeCate]);
}

    /**
     * @Route ("detail",name="detail")
     *
     */
    public function detailAnnonce(EntityManagerInterface $entityManager, Request $request)
    {
        $idUser = $this->getUser();

        $id=$request->query->get('id');

        if ($id){
            $annonce = $entityManager->getRepository('App:Ad') ->annonceById($id);
        }

        if (!$id){
            throw  $this->createNotFoundException('Cette annonce n\'existe pas.');
        }

        return $this->render('Annonce/detailAnnonce.html.twig', ['detailAnnonce' => $annonce, 'idUser' => $idUser
        ]);
    }

    /**
     * @Route ("mesAnnonces",name="mesAnnonces")
     *
     */
    public function mesAnnonces(EntityManagerInterface $entityManager, Request $request)
    {


        $cate = $request->query->get('cate');
        //  Avoir la liste des catégories
        $listeCate = $entityManager->getRepository('App:Categorie')->findAll();

        // Récupération Requête de la barre de recherche
        $recherche = $request->query->get('search');

        if ($cate) {
            $listeAnnonce = $entityManager->getRepository('App:Ad')->triParCateParUser($cate,$this->getUser());
        }
        if (!$cate) {
            if (!$recherche) {

                $listeAnnonce = $entityManager->getRepository('App:Ad')->annonceByUser($this->getUser());
            }
            // Recherche d'une annonce
            if ($recherche){

                $listeAnnonce = $entityManager->getRepository('App:Ad')->actionRechercheParUser($recherche,$this->getUser());
            }
        }


        return $this->render('Annonce/mesAnnonces.html.twig', ['listeAnnonce' => $listeAnnonce, "tableauCate" =>$listeCate
        ]);
    }
}