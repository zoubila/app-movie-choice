<?php

namespace App\Domain;

use DateTime;

class Movie
{
    private int $id;
    private array $titles;
    private array $genres;
    private DateTime $releaseDate;
    private bool $adult;
    private array $originCountries;
    private ?string $posterPath;
    private int $runtime;
    private float $voteAverage;
    private array $directors;
    private array $actors;
    private ?string $overview;
    private array $images;
    private array $reviews;
    private array $videos;
    private ?array $providers;

    public function __construct(
        int $id,
        array $titles,
        array $genres,
        DateTime $releaseDate,
        bool $adult,
        array $originCountries,
        ?string $posterPath,
        int $runtime,
        float $voteAverage,
        array $directors,
        array $actors,
        ?string $overview,
        ?array $images,
        ?array $reviews,
        ?array $videos,
        ?array $providers
    ) {
        $this->id = $id;
        $this->titles = $titles;
        $this->genres = $genres;
        $this->releaseDate = $releaseDate;
        $this->adult = $adult;
        $this->originCountries = $originCountries;
        $this->posterPath = $posterPath;
        $this->runtime = $runtime;
        $this->voteAverage = $voteAverage;
        $this->directors = $directors;
        $this->actors = $actors;
        $this->overview = $overview;
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
    public function getTitles(): array 
    {
         return $this->titles; 
    }
    public function getGenres(): array 
    {
         return $this->genres; 
    }
    public function getReleaseDate(): DateTime 
    {
         return $this->releaseDate; 
    }
    public function getoriginCountries(): array 
    {
         return $this->originCountries; 
    }
    public function getAdult(): bool 
    {
         return $this->adult; 
    }
    public function getPosterPath(): string 
    {
         return $this->posterPath; 
    }
    public function getRuntime(): int 
    {
         return $this->runtime; 
    }
    public function getVoteAverage(): float 
    {
         return $this->voteAverage; 
    }
    public function getDirectors(): array 
    {
         return $this->directors; 
    }
    public function getActors(): array 
    {
         return $this->actors; 
    }
    public function getOverview(): ?string 
    {
         return $this->overview; 
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
}
