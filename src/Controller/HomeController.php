<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\DomaineMetier;
use App\Entity\TypeContrat;
use App\Form\FilterFormType;
use App\Form\FilterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offre;
use App\Form\OffreType;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use function Deployer\test;


class HomeController extends AbstractController
{

    #[Route('/', name: 'redirecthome')]
    public function redirecthome(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        return $this->redirectToRoute('app_home');
    }



    #[Route('/offrecasting/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $form = $this->createForm(FilterType::class);
        $form->handleRequest($request);
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
            'offres' => $offre,
            'form' => $form,
        ]);
    }


    #[Route('/domainemetier/', name: 'app_home_domainemetier')]
    public function domainemetier(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $donnees = $entityManager->getRepository(DomaineMetier::class)->findAll();;
        $domaine = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1 // Nombre de résultats par page
        );
        if ($domaine == null) {
            throw $this->createNotFoundException("Le domaine n'existe pas");
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'domaines' => $domaine
        ]);
    }
    #[Route('/offrecasting/search/', name: 'app_search')]
    public function search(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(FilterType::class, null, [
            'method' => 'GET'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) { 
            $niveauproarray = $form->get('niveauPro')->getData();
            $niveaupro = (!empty($niveauproarray)) ? $niveauproarray[0] : '--';
            $domainemetier = $form->get('domainesMetiers')->getData()->getLibelle();
            $metier = $form->get('metier')->getData()->getLibelle();
            $typecontrat = $form->get('TypeContrats')->getData()->getLibelle();
            $valeur = $form->get('search')->getData() ?? '--';
            $result = $entityManager->getRepository(Offre::class)->findByLibelle($valeur,$niveaupro,$domainemetier,$metier,$typecontrat, $request);
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
                'message'=> $message,
                'form' => $form->createView()
            ]);
            
        }

        $offres = $paginator->paginate(
            $entityManager->getRepository(Offre::class)->findAll(),
            $request->query->getInt('page', 1),
            1
        );
    
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'offres' => $offres,
            'form' => $form->createView()
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

    #[Route('/postuler/{id}', name: 'app_home_postuler')]
    public function postuler(EntityManagerInterface $entityManager, int $id): Response
    {
        $offre = $entityManager->getRepository(Offre::class)->find($id);
        $user = $this->getUser();
        $offre->addOffreUser($user);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }




}
