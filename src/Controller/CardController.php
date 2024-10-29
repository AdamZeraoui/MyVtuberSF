<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CardController extends AbstractController
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

            $cards = $this->entityManager->getRepository(Card::class)->findAll();
            
            // Créer un tableau associant chaque ID à sa rareté
            $cardArray = [];
            foreach ($cards as $card) {
                if ($card->getRarity()) {
                    $cardArray[$card->getId()] = $card->getRarity();
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
            $tirageCardId = $this->tirageFromArray($cardArray, $probabilities);
            
            // Récupérer le Card correspondant à l'ID tiré
            $tirageCard = $this->entityManager->getRepository(Card::class)->find($tirageCardId);

            
            if ($tirageCard) {
                $img =$tirageCard->getName();
                $message = "La carte tiré au sort est : {$tirageCard->getName()} d'une puissance de {$tirageCard->getStats()} avec une rareté de {$tirageCard->getRarity()}.";
                $points = $user->setPoint(($points-$price)); //c'est une fausse erreur.
                
                if ($user) {
                    
                    $user->addRecrute($tirageCard); //c'est une fausse erreur.

                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                }
            } else {
                $message = "Aucun carte trouvé.";
                $img="null";
            }

            
        } else if($points < $price){
            
            $message = "Vous n'avez pas assez de point pour une invocation. Vous avez :". $points." points. une invocation coût ". $price." points."; 
            $img =null;
            
        } else {
            $message = "Vous avez assez de point pour une invocation. Vous avez :". $points." points. une invocation coût ". $price ." points."; 
            $img =null;
        }
        
        return $this->render('gacha/index.html.twig', [
            'message' => $message,'img'=>$img
            ,
        ]);
        
    }

    private function tirageFromArray(array $cards, array $probabilities): int
    {
        $weightedItems = [];

        // Créer un tableau pondéré
        foreach ($cards as $id => $rarity) {
            if (isset($probabilities[$rarity])) {
                $weightedItems = array_merge($weightedItems, array_fill(0, $probabilities[$rarity], $id));
            }
        }

        // Tirer un élément au hasard
        return $weightedItems[array_rand($weightedItems)];
    }

    #[Route('/allCard', name: 'allCard')] //changer le nom /!\ !
    public function allCards(): Response
    {

        $cards = $this->entityManager->getRepository(Card::class)->findAll();

    // Regrouper les Cards par rareté
    $groupedCards = [
        'S' => [],
        'A' => [],
        'B' => [],
        'C' => [],
    ];

    foreach ($cards as $card) {
        $rarity = $card->getRarity();
        $groupedCards[$rarity][] = $card;
    }


        // Cela va rendre un template Twig pour la page d'accueil
        return $this->render('gacha/allCard/index.html.twig', [
            'controller_name' => 'AllCardController',
            'cards' => $cards,
            'groupedCards' => $groupedCards,
        ]
    );}
}
