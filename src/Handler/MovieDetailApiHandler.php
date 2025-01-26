<?

namespace App\Handler;

use App\Domain\Movie;
use App\Service\MovieApiService;
use App\Service\Api\MovieApiDataTransformer;

class MovieDetailApiHandler
{
    private MovieApiService $movieApiService;
    private MovieApiDataTransformer $MovieApiDataTransformer;
    public string $locale;

    public function __construct(MovieApiService $movieApiService, MovieApiDataTransformer $movieDataTransformer)
    {
        $this->movieApiService = $movieApiService;
        $this->MovieApiDataTransformer = $movieDataTransformer;
    }

    public function handle($locale = 'fr-FR'): Movie
    {
        $totalPages = 500;
        $page = rand(1, $totalPages);

        // Fetch random movie ID
        $apiContent = $this->movieApiService->makeApiRequest('discover/movie', [
            'include_adult' => false,
            'include_video' => true,
            'page' => $page,
            'sort_by' => 'popularity.desc',
        ]);

        $randomMovieId = $apiContent['results'][array_rand($apiContent['results'])]['id'];
        // Fetch all related data
        $movieDetails = $this->movieApiService->makeApiRequest("/movie/$randomMovieId", [
            'language' => $locale
        ]);
        $credits = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/credits", [
            'language' => $locale
        ]);
        $images = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/images", [
            'language' => $locale
        ]);
        $reviews = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/reviews", [
            'language' => $locale
        ]);
        $videos = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/videos", [
            'language' => $locale
        ]);
        $providers = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/watch/providers", [
            'language' => $locale
        ]);
        $genre = $this->MovieApiDataTransformer->setGenres($movieDetails['genres']);
        $actors = $this->MovieApiDataTransformer->transformActors($credits['cast']);
        $directors = $this->MovieApiDataTransformer->transformDirectors($credits['crew']);
        $providers = $this->MovieApiDataTransformer->formatProviders($providers, $locale);
        
        // Build and return Movie object
        return new Movie(
            $movieDetails['id'],
            array('title' => $movieDetails['title'],'original_title' => $movieDetails['original_title']),
            $genre,
            new \DateTime($movieDetails['release_date']),
            $movieDetails['adult'],
            $movieDetails['origin_country'],
            $movieDetails['poster_path'] ?? $movieDetails['backdrop_path'] ?? null,
            $movieDetails['runtime'],
            $movieDetails['vote_average'],
            $directors ?? [],
            $actors ?? [],
            $movieDetails['overview'] ?? null,
            $images ?? [],
            $reviews['results'] ?? [],
            $videos['results'] ?? [],
            $providers ?? []
        );
    }
}
