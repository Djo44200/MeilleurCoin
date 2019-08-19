<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccueilController
 * @package App\Controller
 * @Route("")
 */

class AccueilController extends Controller
{

    /**
     * @Route("", name="accueil", methods={"GET"})
     * @Route("home", name="home", methods={"GET"})
     */
    public function accueil() {

        return $this->render('Accueil/accueil.html.twig');
    }

    /**
     * @Route("cgu", name="CGU", methods={"GET"})
     */

    public function cgu(){

        return $this->render('Accueil/cgu.html.twig');
    }

    /**
     * @Route("faq", name="FAQ", methods={"GET"})
     */

    public function faq(){

        return $this->render('Accueil/faq.html.twig');
    }
}