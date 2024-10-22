<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Movie;
use App\Entity\User;
use App\Form\MovieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends AbstractController
{
    #[Route('/movies', name: 'list_movies')]
    public function listMovies(EntityManagerInterface $entityManager): Response
    {
        $movies = $entityManager->getRepository(Movie::class)->findAll();
        
        $user = $this->getUser();

        return $this->render('movies/listMovies.html.twig', [
            'movies'=> $movies,
            'user' => $user,
        ]);
    }

    #[Route('/add-movie', name: 'add_movie')]
    public function addMovie(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $movie = new Movie();

        // Création du formulaire
        $form = $this->createForm(MovieType::class, $movie);

        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde en base de données
            $entityManager->persist($movie);
            $entityManager->flush();

            // Redirection ou message de succès
            return $this->redirectToRoute('list_movies');
        }

        // Afficher le formulaire
        return $this->render('movies/add_movie.html.twig', [
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

}
