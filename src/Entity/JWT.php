<?php
class JWT
{
    public function generate(array $header, array $payload, string $secret, int $validity = 86400 ): string //valide une journée
    {

        if($validity > 0) {
            $nom = new DateTime();
            $expiration = $now->getTimestamp() + $validity;
        }
        
        //Encodage en base64, qui permet de traduire des données binaires en fichier textuels
        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        //On retire les caractères qui ne sont pas supportés
        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);


        //Génération de la signature
        $secret = base64_encode(SECRET);
        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload,
        $secret, true);

        $base64Signature = base64_encode($signature);

        //On nettoie la signature
        $signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64_encode($signature));

        //Création du token
        $jwt = $base64Header . '.' . $base64Payload . '.' . $signature;

        return $jwt;
    }
}


?>
