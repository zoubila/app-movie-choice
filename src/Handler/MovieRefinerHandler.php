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

    public function handle(): int
    {
        $id = 1;
        return $id;
    }
}
