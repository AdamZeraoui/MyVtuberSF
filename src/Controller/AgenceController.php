<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AgenceController extends AbstractController
{
    #[Route('/agence', name: 'app_agence')]


    public function index(UserRepository $userRepository): Response
{
    // Récupérer l'utilisateur courant
    $user = $this->getUser();

    // Récupérer la liste des streamers associés à l'utilisateur
    $streamers = $user ? $user->getRecrute() : []; //fausse erreur

    

    return $this->render('agence/index.html.twig', [
        'controller_name' => 'AgenceController',
        'streamers' => $streamers,
    ]);
}
}
