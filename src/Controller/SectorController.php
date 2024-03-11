<?php

namespace App\Controller;

use App\Service\SectorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class SectorController extends AbstractController
{
    private SectorService $sectorService;

    public function __construct(SectorService $sectorService)
    {
        $this->sectorService = $sectorService;
    }

    #[Route('/api/sectors', name: 'get_sectors', methods: ['GET'])]
    public function getSectors(): JsonResponse
    {
        $sectors = $this->sectorService->getSectors();
        return $this->json($sectors);
    }
}
