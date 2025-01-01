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
    public function getAlternativeTitles(): array 
    {
         return $this->alternativeTitles; 
    }
    public function getImages(): array 
    {
         return $this->images; 
    }
    public function getReviews(): array 
    {
         return $this->reviews; 
    }
    public function getVideos(): array 
    {
         return $this->videos; 
    }
    public function getProviders(): array 
    {
         return $this->providers; 
    }
    public function setId(int $id): void 
    {
         $this->id = $id; 
    }
    public function setTitle(array $title): void 
    {
         $this->title = $title; 
    }
    public function setOverview(?string $overview): void 
    {
         $this->overview = $overview; 
    }
    public function setCredits(array $credits): void 
    {
         $this->credits = $credits; 
    }
    public function setAlternativeTitles(array $alternativeTitles): void 
    {
         $this->alternativeTitles = $alternativeTitles; 
    }
    public function setImages(array $images): void 
    {
         $this->images = $images; 
    }
    public function setReviews(array $reviews): void 
    {
         $this->reviews = $reviews; 
    }
    public function setVideos(array $videos): void 
    {
         $this->videos = $videos; 
    }
    public function setProviders(array $providers): void
    {
         $this->providers = $providers; 
    }
    public function formatOverview(string $overview): string
    {
        $overview = strlen($overview) > 140? substr($overview,0,140).'...' : $overview;
        return $overview;
    }
}
