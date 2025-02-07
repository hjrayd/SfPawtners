<?php

namespace App\HttpClient;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiHttpClient extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpc)
    {
        $this->httpClient = $httpc; //Injection de dépendance depuis le framework.yaml
    }

    public function getBreeds()
    {
        $response = $this->httpClient->request('GET', "/v1/breeds", [ //requête à l'endpoint de l'api (URL spécifique)
            'verify_peer' => false 
        ]);

        return $response->toArray();
    }
}