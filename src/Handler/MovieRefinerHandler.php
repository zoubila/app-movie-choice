<?php

namespace App\Handler;

use App\Domain\Movie;
use App\Service\MovieApiService;
use App\Service\Api\MovieApiDataTransformer;

class MovieRefinerHandler
{
    private MovieApiService $movieApiService;
    private MovieApiDataTransformer $MovieApiDataTransformer;
    public string $locale;

    public function __construct(MovieApiService $movieApiService, MovieApiDataTransformer $movieDataTransformer)
    {
        $this->movieApiService = $movieApiService;
        $this->MovieApiDataTransformer = $movieDataTransformer;
    }

    public function handle(array $filters): int
    {
        $tmdbFilters = [];

        // Adapter les noms aux paramètres TMDB
        $mapping = [
            'language' => 'language',
            'region' => 'region',
            'include_adult' => 'include_adult',
            'include_video' => 'include_video',
            'certification' => 'certification',
            'certification_country' => 'certification_country',
            'certification_lte' => 'certification.lte',
            'primary_release_year' => 'primary_release_year',
            'sort_by' => 'sort_by',
            'vote_average_gte' => 'vote_average.gte',
            'with_genres' => 'with_genres'
        ];

        foreach ($mapping as $formKey => $tmdbKey) {
            if (!empty($filters[$formKey])) {
                if ($formKey === 'with_genres' && is_array($filters[$formKey])) {
                    $tmdbFilters[$tmdbKey] = implode(',', $filters[$formKey]);
                } else {
                    $tmdbFilters[$tmdbKey] = $filters[$formKey];
                }
            }
        }

        // Ajouter une page aléatoire
        $tmdbFilters['page'] = rand(1, 500);
//        dd($tmdbFilters);

        $results = $this->movieApiService->makeApiRequest('discover/movie', $tmdbFilters);

        if (empty($results['results'])) {
            throw new \RuntimeException('Aucun film trouvé avec ces critères.');
        }

        // Choisir un film au hasard
        $randomMovie = $results['results'][array_rand($results['results'])];

        return $randomMovie['id'];
    }
}
