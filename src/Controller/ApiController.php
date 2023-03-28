<?php

namespace App\Controller;

use App\Entity\Offre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
class ApiController extends AbstractController
{
    #[Route('/api/offres', name: 'api_offres', methods: ['GET'])]
    #[OA\Get(summary: 'Retourne une liste des offres')]
    #[OA\Response(response:200, description: 'Liste offres de castings')]
    public function getOffres(EntityManagerInterface $entityManager): JsonResponse
    {
        $offres = $entityManager->getRepository(Offre::class)->findAll();
        return $this->json($offres);
    }
}
