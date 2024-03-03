<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Crea un'applicazione per gli utenti
$app->group(API_DIR . '/rutatori', function ($group) {

    // GET /rutatori
    $group->get('', function (Request $request, Response $response) {

        $httpResponse = new HttpResponse(Status::NotImplemented, "GET all rutatori");
        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    });

    // GET /rutatori/{id}
    $group->get('/{id}', function (Request $request, Response $response, $args) {
        $articleId = $args['id'];
        $rutatore = Rutatore::getRutatoreById($articleId);

        if ($rutatore)
            $httpResponse = new HttpResponse(Status::Ok, "GET rutatore with Id: $articleId", $rutatore->toArray());
        else
            $httpResponse = new HttpResponse(Status::NotFound, "Not Found rutatore with Id: $articleId");

        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    });

})->add(new AuthenticationMiddleware()) ; //* Aggiungi il Middleware di autenticazione a tutto il gruppo
