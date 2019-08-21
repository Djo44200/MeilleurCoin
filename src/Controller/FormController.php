<?php


namespace App\Controller;


use App\Entity\Ad;
use App\Form\AdType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FormController
 * @package App\Controller
 *
 */

class FormController extends Controller
{

    /**
     * @Route("deposer", name="form_deposerAnnonce", methods={"GET", "POST"})
     */
    public function deposerAnnonce(EntityManagerInterface $entityManager, Request $request) {

        // Entité à inflater
        $annonce = new Ad();

        // Formulaire de recherche
        $formAnnonce = $this->createForm(AdType::class, $annonce);
        $formAnnonce->handleRequest($request);

        if ($formAnnonce->isSubmitted() && $formAnnonce->isValid()) {

            // Message de confirmation
            $this->addFlash("success", "Votre annonce a été enregistré !");

            // Enregistrement dans la BDD
            $entityManager->persist($annonce);
            $entityManager->flush();

            // Redirection
            return $this->redirectToRoute("form_deposerAnnonce");
        }

        return $this->render('Annonce/deposerAnnonce.html.twig', ["formDepose" => $formAnnonce->createView()]);
    }



}