<?php

namespace App\Service;

class CurrentPlace
{
    private ?int $placeId = null;

    public function getPlaceId(): ?int
    {
        return $this->placeId;
    }

    public function setPlaceId(int $placeId): static
    {
        $this->placeId = $placeId;

        return $this;
    }
}