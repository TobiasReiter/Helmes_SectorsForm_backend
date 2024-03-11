<?php

namespace App\Service;

use App\Entity\Sector;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class SectorService
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $sectorRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->sectorRepository = $entityManager->getRepository(Sector::class);
    }

    public function getSectors(): array
    {
        $rootSectors = $this->sectorRepository->findBy(['parent' => null]);

        return array_map([$this, 'serializeSector'], $rootSectors);
    }

    private function serializeSector(Sector $sector): array
    {
        $children = $sector->getChildren()->map(function (Sector $child) {
            return $this->serializeSector($child);
        })->toArray();

        return [
            'id' => $sector->getId(),
            'name' => $sector->getName(),
            'depth' => substr_count($sector->getPath(), '/'),
            'children' => $children,
        ];
    }
}