<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeckController extends AbstractController
{
    #[Route('/deck', name: 'app_deck')]


    public function index(UserRepository $userRepository): Response
{
    // Récupérer l'utilisateur courant
    $user = $this->getUser();

    // Récupérer la liste des streamers associés à l'utilisateur
    $cards = $user ? $user->getRecrute() : []; //fausse erreur

    

    return $this->render('deck/index.html.twig', [
        'controller_name' => 'DeckController',
        'cards' => $cards,
    ]);
}
}
