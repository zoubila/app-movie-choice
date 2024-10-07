<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class HomepageController
{
    #[Route('/')]
    public function default(): Response      
    {
        return new Response(
            '<html><body><h1>Homepage</h1></body></html>'
        );
    }
}