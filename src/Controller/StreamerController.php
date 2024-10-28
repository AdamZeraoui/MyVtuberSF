<?php

namespace App\Controller;

use App\Entity\Streamer;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StreamerController extends AbstractController
{
    
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/gacha', name: 'gacha')]
    public function index(Request $request): Response
    {
        $message = null;
        $img=null;
        $user = $this->getUser();
        $points = $user->getPoint() ;
        $price = 550;

        // Vérifier si le formulaire a été soumis
        if ($request->isMethod('POST') && $points > $price) {

            $streamers = $this->entityManager->getRepository(Streamer::class)->findAll();
            
            // Créer un tableau associant chaque ID à sa rareté
            $streamerArray = [];
            foreach ($streamers as $streamer) {
                if ($streamer->getRarity()) {
                    $streamerArray[$streamer->getId()] = $streamer->getRarity();
                }
            }
            
            // Probabilités pour chaque tier
            $probabilities = [
                'S' => 5, // 5%
                'A' => 15, // 15%
                'B' => 30, // 30%
                'C' => 50, // 50%
            ];
            
            // Tirage au sort
            $tirageStreamerId = $this->tirageFromArray($streamerArray, $probabilities);
            
            // Récupérer le streamer correspondant à l'ID tiré
            $tirageStreamer = $this->entityManager->getRepository(Streamer::class)->find($tirageStreamerId);

            
            if ($tirageStreamer) {
                $img =$tirageStreamer->getPseudo();
                $message = "Le streamer tiré au sort est : {$tirageStreamer->getPseudo()} (ID: $tirageStreamerId) avec la rareté {$tirageStreamer->getRarity()}.";
                $points = $user->setPoint(($points-$price));
                
                if ($user) {
                    
                    $user->addRecrute($tirageStreamer); //c'est une fausse erreur.

                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                }
            } else {
                $message = "Aucun streamer trouvé.";
                $img="null";
            }

            
        } else if($points < $price){
            
            $message = "Vous n'avez pas assez de point pour un tirage. Vous avez :". $points." points. Un tirage coût ". $price." points."; 
            $img ="null";
            
        } else {
            $message = "Vous avez assez de point pour un tirage. Vous avez :". $points." points. Un tirage coût ". $price ." points."; 
            $img ="null";
        }
        
        return $this->render('gacha/index.html.twig', [
            'message' => $message,'img'=>$img
            ,
        ]);
        
    }

    private function tirageFromArray(array $streamers, array $probabilities): int
    {
        $weightedItems = [];

        // Créer un tableau pondéré
        foreach ($streamers as $id => $rarity) {
            if (isset($probabilities[$rarity])) {
                $weightedItems = array_merge($weightedItems, array_fill(0, $probabilities[$rarity], $id));
            }
        }

        // Tirer un élément au hasard
        return $weightedItems[array_rand($weightedItems)];
    }

    #[Route('/allStreamer', name: 'allStreamer')]
    public function allStreamers(): Response
    {

        $streamers = $this->entityManager->getRepository(Streamer::class)->findAll();

    // Regrouper les streamers par rareté
    $groupedStreamers = [
        'S' => [],
        'A' => [],
        'B' => [],
        'C' => [],
    ];

    foreach ($streamers as $streamer) {
        $rarity = $streamer->getRarity();
        $groupedStreamers[$rarity][] = $streamer;
    }


        // Cela va rendre un template Twig pour la page d'accueil
        return $this->render('gacha/allStreamer/index.html.twig', [
            'controller_name' => 'AllStreamerController',
            'streamers' => $streamers,
            'groupedStreamers' => $groupedStreamers,
        ]
    );}
}