<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends Controller
{

    /**
     * @Route("", name="accueil", methods={"GET"})
     */
    public function accueil() {

        return $this->render('Accueil/accueil.html.twig');
    }
}