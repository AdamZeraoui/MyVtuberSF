<?php

namespace App\Controller;


use App\Entity\Card;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MatController extends AbstractController
{
    #[Route('/mat', name: 'app_mat')]
    public function index(): Response
    {

    $user = $this->getUser();

    $cards = $user->getRecrute();

        return $this->render('mat/index.html.twig', [
            'controller_name' => 'MatController',
            'cards' => $cards,
        ]);
    }
}
