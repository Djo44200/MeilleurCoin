<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $req=$entityManager->getRepository('App:Ad')->findAll();
        return $this->render('Annonce/listeAnnonce.html.twig', ["tableauAnnonce" => $req]);
}

}