<?php

namespace App\Service;

use App\Entity\Place;
use Doctrine\ORM\EntityManagerInterface;

class CurrentPlace
{
    private ?int $placeId = null;

    private EntityManagerInterface $entityManager;
    // Assuming you have Doctrine's EntityManagerInterface injected into this service
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getPlaceId(): ?int
    {
        $this->placeId = 4;
        $_SESSION['place_id'] = 4;
        if ($this->placeId === null) {
            if (isset($_SESSION['place_id'])) {
                $this->placeId = $_SESSION['place_id'];
            } else {
                $place = $this->entityManager->getRepository(Place::class)->findOneBy([ 'name' => 'Tisch 4' ]);
                if ($place !== null) {
                    $this->setPlaceId($place->getId());
                }
            }
        }
        return $this->placeId;
    }

    public function getPlaceName(): ?string
    {
        $place = $this->entityManager->getRepository(Place::class)->find($this->getPlaceId());
        return $place ? $place->getName() : null;
    }

    public function getAllPlaces(): array
    {
        return $this->entityManager->getRepository(Place::class)->findAll();
    }

    public function setPlaceId(int $placeId): static
    {
        $this->placeId = $placeId;
        $_SESSION['place_id'] = $placeId;
        return $this;
    }
}
