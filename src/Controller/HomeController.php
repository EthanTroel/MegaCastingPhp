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

class HomeController extends AbstractController
{
    #[Route('/offrecasting/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $offre = $entityManager->getRepository(Offre::class)->findAll();;
        if ($offre == null) {
            throw $this->createNotFoundException("L'offre n'existe pas");
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'offres' => $offre
        ]);
    }
    #[Route('/offrecasting/search/', name: 'app_search')]
    public function search(Request $request, EntityManagerInterface $entityManager)
    {
        $valeur = $request->query->get('search');
        $result = $entityManager->getRepository(Offre::class)->findByLibelle($valeur, $request);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'offres' => $result
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
