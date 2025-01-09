<?php

namespace App\Command;

use App\Entity\Breed;  // Assure-toi d'avoir une entité Breed
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImportCatBreedsCommand extends Command
{
    private $client;
    private $entityManager;

    public function __construct(HttpClientInterface $client, EntityManagerInterface $entityManager)
    {
        $this->client = $client;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected static $defaultName = 'app:import-cat-breeds';

    protected function configure()
    {
        $this->setDescription('Importe les races de chats depuis l\'API et les insère dans la base de données.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $apiUrl = 'https://api.thecatapi.com/v1/breeds';
        $apiKey = $_ENV['CAT_API_KEY'];


        // Effectuer la requête GET vers l'API
        $response = $this->client->request('GET', $apiUrl, [
            'headers' => [
                'x-api-key' => $apiKey,
            ],
        ]);

        // Récupérer la réponse JSON
        $breedsData = $response->toArray();

        // Insérer les données dans la base de données
        foreach ($breedsData as $breedData) {
            $breed = new Breed();
            $breed->setName($breedData['name']);
            $breed->setDescription($breedData['description']);
            
            // Sauvegarde dans la base de données
            $this->entityManager->persist($breed);
        }

        // Enregistrer toutes les nouvelles entités dans la base de données
        $this->entityManager->flush();

        $output->writeln('Les races de chats ont été importées avec succès !');

        return Command::SUCCESS;
    }
}

