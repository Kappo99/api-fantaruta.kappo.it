<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;

// Endpoint per il login e la creazione del token
$app->post('/login', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $email = $data['email'];
    $password = $data['password']; // TODO: crittografare la password (md5 NON troppo sicuro)

    $rutatore = Rutatore::authenticateUser($email, $password);

    if ($rutatore !== null) {
        // Se l'autenticazione ha successo, crea il token JWT
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600 * 24; // Token valido per 1 giorno

        $payload = [
            'Id_Rutatore' => $rutatore->getId(),
            'Name_Rutatore' => $rutatore->getName(),
            'iat' => $issuedAt,
            'exp' => $expirationTime,
        ];

        $token = JWT::encode($payload, JWT_SECRET_KEY, 'HS256');

        $httpResponse = new HttpResponse(
            Status::Ok,
            "Login avvenuto con successo",
            ['token' => $token, 'idRutatore' => $rutatore->getId()]
        );
    } else {
        $httpResponse = new HttpResponse(Status::Unauthorized, "Errore di autenticazione");
    }

    $response->getBody()->write($httpResponse->send());
    $response = $response->withStatus($httpResponse->getStatusCode());
    return $response;
});
