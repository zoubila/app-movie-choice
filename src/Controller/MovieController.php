<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Movie;
use App\Entity\User;
use App\Form\MovieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\MovieApiService;
use App\Service\Api\MovieApiDataTransformer;

class MovieController extends AbstractController
{
    private MovieApiService $movieApiService;
    private MovieApiDataTransformer $movieDataTransformer;
    public function __construct(MovieApiService $movieApiService, MovieApiDataTransformer $movieDataTransformer)
    {
        $this->movieApiService = $movieApiService;
        $this->movieDataTransformer = $movieDataTransformer;
    }
    
    #[Route('/movies-old', name: 'list_movies')]
    public function listMovies(EntityManagerInterface $entityManager): Response
    {
        $movies = $entityManager->getRepository(Movie::class)->findAll();
        
        $user = $this->getUser();

        return $this->render('movies/listMovies.html.twig', [
            'movies'=> $movies,
            'user' => $user,
        ]);
    }

    #[Route('/movie', name: 'movie')]
    public function movie(Request $request, MovieApiService $movieApiService, MovieApiDataTransformer $movieDataTransformer): Response
    {
        
        $user = $this->getUser();
        $totalPages = 500;
        $page = rand(1, $totalPages);

        $apiContent = $this->movieApiService->makeApiRequest('discover/movie', [
            'include_adult' => false,
            'include_video' => true,
            'page' => $page,
            'sort_by' => 'popularity.desc'
        ]);

        
        $randomMovie = $apiContent['results'][array_rand($apiContent['results'])]['id'];

        $endpointMovie = $this->movieApiService->makeApiRequest("/movie/$randomMovie", [
            'language' => 'fr-FR'
        ]);

        return $this->render('movies/movie_proposal.html.twig', [
            'nav_color' => 'movie-home-link',
            'backgroundClass' => 'movie-background',
            'user' => $user,
            'detail-movie' => $endpointMovie
        ]);
    }

    #[Route('/add-movie', name: 'add_movie')]
    public function addMovie(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $movie = new Movie();

        // Création du formulaire
        $form = $this->createForm(MovieType::class, $movie);

        // Gestation de la submission du formulate
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde en base de données
            $entityManager->persist($movie);
            $entityManager->flush();

            // Redirection ou message de succès
            return $this->redirectToRoute('list_movies');
        }

        // Afficher le formulaire
        return $this->render(view: 'movies/add_movie.html.twig', parameters: [
            'form' => $form->createView(),
            'user'=> $user,
        ]);
    }

    #[Route('/search-movie/{title}', name: 'search_movie')]
    public function searchMovie(EntityManagerInterface $entityManager, string $title): Response
    {
        $movies = $entityManager->getRepository(Movie::class)->findBy(['title' => $title]);

        if (!$movies) {
            return new Response('No movies found for title '.$title);
        }

        $content = '<h1>Search Results</h1><ul>';
        foreach ($movies as $movie) {
            $content .= sprintf('<li>%s - %s</li>', $movie->getTitle(), $movie->getReleaseDate()->format('Y-m-d'));
        }
        $content .= '</ul>';

        return new Response($content);
    }

    /**
     * @throws Exception
     */
    #[Route('/movie-proposal', name: 'movie_proposal')]
    public function api_movieProposition(Request $request, MovieApiService $movieApiService): Response
    {
        $user = $this->getUser();

        $apiContent = $this->movieApiService->makeApiRequest('trending/movie/week', [
            'language' => 'fr'
        ]);

        return $this->render('movies/movie_proposal.html.twig', [
            'backgroundClass' => 'movie-background',
            'user'=> $user,
            'api_content'=> $apiContent,
        ]);
    }

}
