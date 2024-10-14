<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class HomepageController extends AbstractController
{
    #[Route('/homepage', name:'homepage')]
    #[Route('/')]
    public function default(): Response 
    {
        $user = $this->getUser();

        return $this->render('base.html.twig', [
            'test' => true,
            'user' => $user
        ]);
    }
}