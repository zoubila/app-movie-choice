<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Service\MovieApiService;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends AbstractController
{
    private MovieApiService $movieApiService;
    public function __construct(MovieApiService $movieApiService)
    {
        $this->movieApiService = $movieApiService;
    }
    #[Route('/homepage', name:'homepage')]
    #[Route('/')]
    public function default(Request $request, MovieApiService $movieApiService): Response 
    {
        $user = $this->getUser();

        $apiContent = $this->movieApiService->makeApiRequest('trending/movie/week', [
            'language' => 'fr'
        ]);

        return $this->render('base.html.twig', [
            'test' => true,
            'user' => $user,
            'api_content'=> $apiContent,
        ]);
    }
}