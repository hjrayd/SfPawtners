<?php
namespace App\Service;

use DateTimeImmutable;

class JWTService
{

     //On génère un token
    public function generate(array $header, array $payload, string $secret, int $validity = 10800): string
    {
        if($validity > 0){
            $now = new DateTimeImmutable();
            $exp = $now->getTimestamp() + $validity;
    
            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $exp;
        }

        //Encodage en base64, qui permet de traduire des données binaires en fichier textuels
        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

       //On retire les caractères qui ne sont pas supportés
        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

        //Génération de la signature
        $secret = base64_encode($secret);
        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);

        $base64Signature = base64_encode($signature);

        //On nettoie la signature
        $signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        //Création du token
        $jwt = $base64Header . '.' . $base64Payload . '.' . $signature;

        return $jwt;
    }


    //On vérifie que le token est au bon format
    public function isValid(string $token): bool
    {
        //Si le token correspond à l'expression -> la fonction renverra 1
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token
        ) === 1;
    }


    //On récupère le payload
    public function getPayload(string $token): array
    {
      
        $array = explode('.', $token);

     
        $payload = json_decode(base64_decode($array[1]), true);

        return $payload;
    }

    
    //On récupère le header
    public function getHeader(string $token): array
    {
       
        $array = explode('.', $token);

       
        $header = json_decode(base64_decode($array[0]), true);

        return $header;
    }

    //On vérifie si le token a expiré 
    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);

        $now = new DateTimeImmutable();

        return $payload['exp'] < $now->getTimestamp();
    }

    //On vérifie à nouveau le token est valide et qu'il n'a pas été modifié par un tiers
    public function check(string $token, string $secret)
    {

        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

      
        $verifToken = $this->generate($header, $payload, $secret, 0);

        return $token === $verifToken;
    }
}