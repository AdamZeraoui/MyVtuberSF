<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController

{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        // Cela va rendre un template Twig pour la page d'accueil
        return $this->render('home/index.html.twig', [
            "message" => "Bienvenue sur My Vtuber", "inscription"=>"S'inscrire", "profil"=>"Profil", "agence"=> "Agence", "chambre"=>"Chambre"
        ]
    );}
}
