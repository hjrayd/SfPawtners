<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CityController extends AbstractController
{
    #[Route('api/cities', name: 'api_cities')]
    public function getCities(HttpClientInterface $httpClient)
    {
         // L'URL de l'API Geo Gouv pour récupérer les villes
    $url = 'https://geo.api.gouv.fr/communes?nom=';

    // Paramètre 'q' pour la recherche dans l'URL
    $query = $_GET['q'] ?? '';  // On récupère la donnée qui a été transmise depuis la recherche

    // Requête à l'API pour récuperer les communes
    $response = $httpClient->request('GET', $url . $query, [
        'headers' => [
            'Accept' => 'application/json', //On précise qu'on souhaite récupérere le résultat sous un format JSON
        ],
    ]);

    // On convertit la réponse JSON en un tableau
    $data = $response->toArray();

    // On formate les résultats pour Select2
    $results = array_map(function ($city) {
        return [
            'id' => $city['code'], // code INSEE pour l'ID
            'text' => $city['nom'] // nom de la ville pour l'affichage
        ];
    }, $data);

    // On retourne le résultat sous format JSON car la partie Front attend ce format
    return new JsonResponse($results);
    }
}

?>
