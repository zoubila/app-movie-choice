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

    private const PICTURE_FALLBACK = '/build/images/siege_vide.png';

    public function __construct(MovieApiService $movieApiService, MovieApiDataTransformer $movieDataTransformer)
    {
        $this->movieApiService = $movieApiService;
        $this->MovieApiDataTransformer = $movieDataTransformer;
    }

    public function handle($id, $locale = 'fr-FR'): Movie
    {
        if($id) {
            $randomMovieId = $id;
        } else {
            $filtersGeneralApiCall = [
                'include_adult' => true,
                'include_video' => true,
                'watch_region' => 'FR',
//                'certification' => 'R18',
//                'certification_country' => 'FR',
                'page' => rand(1, 500),
                'sort_by' => 'popularity.desc',
            ];
            $apiContent = $this->movieApiService->makeApiRequest('discover/movie', $filtersGeneralApiCall);

            if($apiContent['total_pages'] < 500){
                $filtersGeneralApiCall['page'] = rand(1, $apiContent['total_pages']);
                $apiContent = $this->movieApiService->makeApiRequest('discover/movie', $filtersGeneralApiCall);
            }

            $randomMovieId = $apiContent['results'][array_rand($apiContent['results'])]['id'];
//            $randomMovieId = 427641;
//            $randomMovieId = 430378; // films sans images
        }

        $movieDetails = $this->movieApiService->makeApiRequest("/movie/$randomMovieId", [
            'language' => $locale
        ]);
        $credits = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/credits", [
            'language' => $locale
        ]);
        $images = $this->movieApiService->makeApiRequest("/movie/$randomMovieId/images");
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
            $movieDetails['poster_path']
                ?? $movieDetails['backdrop_path']
                ?? self::PICTURE_FALLBACK,
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
