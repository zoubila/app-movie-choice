<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\MovieApiService;
use App\Service\Api\MovieApiDataTransformer;

class HomepageController extends AbstractController
{
    private MovieApiService $movieApiService;
    private MovieApiDataTransformer $movieDataTransformer;
    public function __construct(MovieApiService $movieApiService, MovieApiDataTransformer $movieDataTransformer)
    {
        $this->movieApiService = $movieApiService;
        $this->movieDataTransformer = $movieDataTransformer;
    }
    #[Route('/homepage', name:'homepage')]
    #[Route('/')]
    public function default(Request $request, MovieApiService $movieApiService, MovieApiDataTransformer $movieDataTransformer): Response 
    {
        $user = $this->getUser();

        $apiContent = $this->movieApiService->makeApiRequest('trending/movie/week', [
            'language' => 'fr'
        ]);

        $transformedContent = $this->movieDataTransformer->transformApiDataHomepage($apiContent);

        return $this->render('base.html.twig', [
            'user' => $user,
            'api_content'=> $transformedContent,
        ]);
    }
}