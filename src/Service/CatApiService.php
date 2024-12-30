<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface; 

class CatApiService 
{
    private HttpClientInterface $httpClient; //Permet d'effectuer les requêtes HTTP
    private string $apiUrl = 'https://api.thecatapi.com/v1/breeds'; //Url de l'api qui permet de récupérer les races de chats
    private string $apiKey; //La clé API qui permet d'authentifier les requêtes (séurité)

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    public function fetchBreeds(): array
    {
        $response = $this->httpClient->request('GET', $this->apiUrl, [ //Envoie une requête HTTP de type Get vers l'url que l'on à définit
            'headers' => [
                'x-api-key' => $this->apiKey, //On s'authentifie auprès de l'API (sécurité)
            ],
        ]);

        if($response->getStatusCode() !== 200) //Si le code de statuts HTTP n'est pas 200 (succès) alors on renvoie un message d'erreur
        {
            throw new \Exception('Un problème est survenu');
        }

        return $reponse->toArray(); //Le résultat est renvoyé sous forme de tableau associatif
    }
}
?>