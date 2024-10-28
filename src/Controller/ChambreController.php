<?php

namespace App\Controller;


use App\Entity\Streamer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ChambreController extends AbstractController
{
    #[Route('/chambre', name: 'app_chambre')]
    public function index(): Response
    {

    $user = $this->getUser();

    $streamers = $user->getRecrute();

        return $this->render('chambre/index.html.twig', [
            'controller_name' => 'ChambreController',
            'streamers' => $streamers,
        ]);
    }
}
