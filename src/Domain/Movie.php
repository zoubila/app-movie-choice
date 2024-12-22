<?php

namespace App\Domain;

class Movie
{
    private int $id;
    private array $title;
    private ?string $overview;
    private array $credits;
    private array $alternativeTitles;
    private array $images;
    private array $reviews;
    private array $videos;
    private array $providers;

    public function __construct(
        int $id,
        array $title,
        ?string $overview,
        array $credits,
        array $alternativeTitles,
        array $images,
        array $reviews,
        array $videos,
        array $providers
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->overview = $overview;
        $this->credits = $credits;
        $this->alternativeTitles = $alternativeTitles;
        $this->images = $images;
        $this->reviews = $reviews;
        $this->videos = $videos;
        $this->providers = $providers;
    }

    // Getters (ajouter ceux nécessaires)
    public function getId(): int 
    { 
        return $this->id; 
    }
    public function getTitle(): array 
    {
         return $this->title; 
    }
    public function getOverview(): ?string 
    {
         return $this->overview; 
    }
    public function getCredits(): array 
    {
         return $this->credits; 
    }
}
