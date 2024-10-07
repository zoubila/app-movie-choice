<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class MovieController extends AbstractController
{
    #[Route('/movies', name: 'list_movies')]
    public function listMovies(EntityManagerInterface $entityManager): Response
    {
        $movies = $entityManager->getRepository(Movie::class)->findAll();
    
        $content = '<h1>Movies</h1><ul>';
        foreach ($movies as $movie) {
            $content .= sprintf('<li>%s - %s</li>', $movie->getTitle(), $movie->getReleaseDate()->format('Y-m-d'));
        }
        $content .= '</ul>';
    
        return new Response($content);
    }

    #[Route('/add-movie', name: 'add_movie')]
    public function addMovie(EntityManagerInterface $entityManager): Response
    {
        $movie = new Movie();
        $movie->setTitle('Inception');
        $movie->setReleaseDate(new \DateTime('2010-07-16'));

        $entityManager->persist($movie);
        $entityManager->flush();

        return new Response('Saved new movie with id '.$movie->getId());
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
