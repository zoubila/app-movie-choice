<?php

namespace App\Service\Api;

class MovieApiDataTransformer
{
    public function transformApiDataHomepage(array $data): array
    {
        foreach ($data['results'] as &$movie) {
            $movie['vote_average'] = $this->roundRating($movie['vote_average']);
        }
        foreach ($data['results'] as &$movie) {
            $movie['release_date'] = $this->formatDate($movie['release_date']);
        }
        foreach ($data['results'] as &$movie) {
            $movie['overview'] = $this->formatOverview($movie['overview']);
        }
        foreach ($data['results'] as &$movie) {
            $movie['title'] = $this->formatTitle($movie['title']);
        }
        return $data;
    }

    public function setGenres(array $data): array
    {
        $genres = [];
        foreach ($data as $genre) {
            $genres[] = $genre['name'];
        }
        return $genres;
    }

    public function roundRating(float $rating): float
    {
        return round($rating, 1);
    }

    public function formatDate(string $date): string
    {
        $date = date('Y');
        return $date;
    }

    public function formatOverview(string $overview): string
    {
        $overview = strlen($overview) > 140? substr($overview,0,140).'...' : $overview;
        return $overview;
    }
    public function formatTitle(string $title): string
    {
        $title = strlen($title) > 30? substr($title,0,30).'...' : $title;
        return $title;
    }
}
