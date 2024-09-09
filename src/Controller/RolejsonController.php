<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RolejsonController extends AbstractController
{
    #[Route('/rolejson', name: 'app_rolejson')]
    public function index(): Response
    {
        return $this->render('rolejson/index.html.twig', [
            'controller_name' => 'RolejsonController',
        ]);
    }
}
