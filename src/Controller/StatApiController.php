<?php

namespace App\Controller;

use App\Repository\TrajetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatApiController extends AbstractController
{
    



    #[Route('/statique/stat', name: 'statique_app_name')]
    public function displayDonStats(TrajetRepository $donRepository): Response
    {
        $stats = $donRepository->countdarrive();

        return $this->render('Stat/index.html.twig', [
            'stats' => $stats,
        ]);
    }
}
