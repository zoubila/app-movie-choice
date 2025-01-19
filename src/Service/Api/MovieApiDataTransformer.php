<?php

namespace App\Service\Api;

use App\Domain\Actors;
use App\Domain\Director;

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

    /**
     * Transforme un tableau d'API en une collection d'objets Actors
     *
     * @param array $actorsData
     * @return Actors[]
     */
    public function transformActors(array $actorsData): array
    {

        foreach ($actorsData as $actor) {
            if (isset($actor['profile_path']) && $actor['profile_path'] !== '' && $actor['order'] < 10 || $actor['popularity'] > 30) {
                $actorObj[] = new Actors(
                    $actor['adult'],
                    $actor['gender'],
                    $actor['id'],
                    $actor['name'],
                    $actor['original_name'],
                    $actor['popularity'],
                    $actor['profile_path'] ?? ''
                );
            }
        }
        return $actorObj;
    }

        /**
     * Transforme un tableau d'API en une collection d'objets Director
     *
     * @param array $directorsData
     * @return Director[]
     */
    public function transformDirectors(array $directorsData): array
    {
        foreach ($directorsData as $director) {
            if (isset($director['job']) && $director['job'] === 'Director') {
                $directorObj[] = new Director(
                    $director['adult'],
                    $director['gender'],
                    $director['id'],
                    $director['name'],
                    $director['original_name'],
                    $director['popularity'],
                    $director['profile_path'] ?? ''
                );
            }
        }

        return $directorObj;
    }
}
