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
        // $randomMovieId = 457332;
        // Fetch all related data
        $movieDetails = $this->movieApiService->makeApiRequest("/movie/$randomMovieId", [
            'language' => $locale
        ]);
        $credits = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/credits", [
            'language' => $locale
        ]);
        $alternativeTitles = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/alternative_titles", [
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
        
        // Build and return Movie object
        return new Movie(
            $movieDetails['id'],
            $genre,
            $movieDetails['production_countries'],
            $movieDetails,
            $movieDetails['overview'] ?? null,
            $credits['cast'] ?? [],
            $alternativeTitles['titles'] ?? [],
            $images['backdrops'] ?? [],
            $reviews['results'] ?? [],
            $videos['results'] ?? [],
            $providers['results'] ?? []
        );
    }
}
