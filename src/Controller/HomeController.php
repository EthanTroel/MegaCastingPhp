<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\TypeContrat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offre;
use App\Form\OffreType;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;



class HomeController extends AbstractController
{
    #[Route('/offrecasting/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $donnees = $entityManager->getRepository(Offre::class)->findAll();;
        $offre = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1 // Nombre de résultats par page
        );
        if ($offre == null) {
            throw $this->createNotFoundException("L'offre n'existe pas");
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'offres' => $offre
        ]);
    }
    #[Route('/offrecasting/search/', name: 'app_search')]
    public function search(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $valeur = $request->query->get('search');
        $result = $entityManager->getRepository(Offre::class)->findByLibelle($valeur, $request);
        $offres = $paginator->paginate(
            $result,
            $request->query->getInt('page', 1),
            1
        );
        $message = null;
        if ($offres->count() == 0) {
            $message = "Aucune offre ne correspond à votre recherche.";
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'offres' => $offres,
            'message'=> $message
        ]);
    }





    #[Route('/offrecasting/offre/', name: 'app_offre_detail')]
    public function offre(Request $request, EntityManagerInterface $entityManager): Response
    {
        $id = $request->query->get('id');
        $offre = $entityManager->getRepository(Offre::class)->find($id);
        if ($offre == null) {
            throw $this->createNotFoundException("Aucune offre n'a été trouvée");
        }

        return $this->render('home/offre.html.twig', [
            'controller_name' => 'OffreController',
            'offre' => $offre
        ]);
    }

    #[Route('/offrecasting/form/', name: 'app_form')]
    public function form(Request $request): Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);

        $form->handleRequest($request);
        if($form->isSubmitted()){

            //enregistrer en BDD

            return $this->redirectToRoute('offrecasting_show', ['id' => $offre->getId()]);
        }
        return $this->render('home/form.html.twig', [
            'form' => $form,
        ]);

        $form = $form->handleRequest($request);

        return $this->render('home/form.html.twig', [
            $form = $this->createForm(FormType::class, $form )
        ]);
    }

}
