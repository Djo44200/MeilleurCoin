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
    public function touteAnnonce(EntityManagerInterface $entityManager)
    {
        $req=$entityManager->getRepository('App:Ad')->findAllOrderBy();
        return $this->render('Annonce/listeAnnonce.html.twig', ["tableauAnnonce" => $req]);
}

    /**
     * @Route ("detail",name="detail")
     *
     */
    public function detailAnnonce(EntityManagerInterface $entityManager, Request $request)
    {
        $id=$request->query->get('id');
        $ad = new Ad();
        if ($id){
            $annonce = $entityManager->getRepository('App:Ad') ->annonceById($id);
        }

        if (!$id){
            throw  $this->createNotFoundException('Cette annonce n\'existe pas.');
        }

        return $this->render('Annonce/detailAnnonce.html.twig', array(
            'detailAnnonce' => $annonce,
        ));
    }

}