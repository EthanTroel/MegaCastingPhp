<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\FicheMetier;

class FichesMetiersController extends AbstractController
{
    #[Route('/fichesmetiers/', name: 'app_fichesmetiers')]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $donnees = $entityManager->getRepository(FicheMetier::class)->findAll();;
        $fichemetier = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1 // Nombre de résultats par page
        );
        if ($fichemetier == null) {
            throw $this->createNotFoundException("Le metier n'existe pas");
        }

        return $this->render('fiches_metiers/index.html.twig', [
            'controller_name' => 'FichesMetiersController',
            'fichesmetiers' => $fichemetier
        ]);
    }



}
