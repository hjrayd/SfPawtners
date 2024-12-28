<?php

namespace App\Service;


//Création du header
$header = [
    'typ' => 'JWT', //type de token
    'alg' => 'HS256' //algorithme de hachage du token
];

//Création du contenu (payload)
$payload = [
    'user_id' => 123,
    'email' => 'contact@demo.fr'
  
];


//Encodage en base64, qui permet de traduire des données binaires en fichier textuels
$base64Header = base64_encode(json_encode($header));
$base64Payload = base64_encode(json_encode($payload));

//On retire les caractères qui ne sont pas supportés
$base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
$base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);


//Génération de la signature
$secret = getenv('APP_JWTSECRET');
$secret = base64_encode('SECRET');
$signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload,
$secret, true);

$base64Signature = base64_encode($signature);

//On nettoie la signature
$signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

//Création du token
$jwt = $base64Header . '.' . $base64Payload . '.' . $signature;

?>
