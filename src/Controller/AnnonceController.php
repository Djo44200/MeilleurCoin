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
    public function touteAnnonce(EntityManagerInterface $entityManager, Request $request)
    {
        $cate = $request->query->get('cate');

        $listeCate = $entityManager->getRepository('App:Categorie')->findAll();
        //$nombreAnnonce = $entityManager->getRepository('App:Ad')->nombreAnnonces();

        // Si id existe alors affichage des données dans le formulaire
        if ($cate) {
            $req = $entityManager->getRepository('App:Ad')->triParCate($cate);
        }
        if (!$cate) {

        $req = $entityManager->getRepository('App:Ad')->findAllOrderBy();
    }
        return $this->render('Annonce/listeAnnonce.html.twig', ["tableauAnnonce" => $req, "tableauCate" =>$listeCate]);
}

    /**
     * @Route ("detail",name="detail")
     *
     */
    public function detailAnnonce(EntityManagerInterface $entityManager, Request $request)
    {
        $id=$request->query->get('id');

        if ($id){
            $annonce = $entityManager->getRepository('App:Ad') ->annonceById($id);
        }

        if (!$id){
            throw  $this->createNotFoundException('Cette annonce n\'existe pas.');
        }

        return $this->render('Annonce/detailAnnonce.html.twig', ['detailAnnonce' => $annonce
        ]);
    }


}