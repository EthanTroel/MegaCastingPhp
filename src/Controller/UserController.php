<?php

namespace App\Controller;

use App\Form\UserFormType;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user'=>$user,
        ]);
    }




    #[Route("/userniveaupro", name: "update_niveaupro")]
    public function updateNiveauPro(Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
        $niveaupromodif = $user->getNiveauPro();
        $niveaupromodif = $request->request->get('niveaupro');
        if ($niveaupromodif === null) {
            $niveaupromodif = 'Sans Diplôme';
        }

        $user->setNiveauPro($niveaupromodif);

        $userRepository = $entityManager->getRepository(User::class);
        $userToUpdate = $userRepository->find($user->getId());
        $userToUpdate->setNiveauPro($niveaupromodif);
        $entityManager->flush();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user'=>$user,
        ]);
    }



}

