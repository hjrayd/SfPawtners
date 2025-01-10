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
    $query = $_GET['q'] ?? '';  // Récupère le terme de recherche depuis la requête

    // Faire la requête GET à l'API Geo Gouv
    $response = $httpClient->request('GET', $url . $query, [
        'headers' => [
            'Accept' => 'application/json',
        ],
    ]);

    // Décoder la réponse JSON
    $data = $response->toArray();

    // Formater les résultats pour Select2
    $results = array_map(function ($city) {
        return [
            'id' => $city['code'], // code postal comme ID
            'text' => $city['nom'] // nom de la ville comme texte affiché
        ];
    }, $data);

    // Retourner les données sous format JSON
    return new JsonResponse($results);
    }
}

?>
