<?

namespace App\Handler;

use App\Domain\Movie;
use App\Service\MovieApiService;
use App\Service\Api\MovieApiDataTransformer;

class MovieDetailApiHandler
{
    private MovieApiService $movieApiService;
    private MovieApiDataTransformer $MovieApiDataTransformer;

    public function __construct(MovieApiService $movieApiService, MovieApiDataTransformer $movieDataTransformer)
    {
        $this->movieApiService = $movieApiService;
        $this->MovieApiDataTransformer = $movieDataTransformer;
    }

    public function handle(): Movie
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
            'language' => 'fr-FR'
        ]);
        $credits = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/credits", [
            'language' => 'fr-FR'
        ]);
        $alternativeTitles = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/alternative_titles", [
            'language' => 'fr-FR'
        ]);
        $images = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/images", [
            'language' => 'fr-FR'
        ]);
        $reviews = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/reviews", [
            'language' => 'fr-FR'
        ]);
        $videos = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/videos", [
            'language' => 'fr-FR'
        ]);
        $providers = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/watch/providers", [
            'language' => 'fr-FR'
        ]);
        


        
        // Build and return Movie object
        return new Movie(
            $movieDetails['id'],
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
