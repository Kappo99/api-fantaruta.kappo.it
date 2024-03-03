<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Crea un'applicazione per gli utenti
$app->group(API_DIR . '/rutazioni', function ($group) {

    // GET /rutazioni
    $group->get('', function (Request $request, Response $response) {

        $httpResponse = new HttpResponse(Status::NotImplemented, "GET all rutazioni");
        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    });

    // GET /rutazioni/{giornata}
    $group->get('/{giornata}', function (Request $request, Response $response, $args) {
        $giornata = $args['giornata'];
        $rutazioni = Rutazione::getRutazioniByGiornata($giornata);

        if ($rutazioni)
            $httpResponse = new HttpResponse(Status::Ok, "GET rutazioni with Giornata: $giornata", $rutazioni->toArray());
        else
            $httpResponse = new HttpResponse(Status::NotFound, "Not Found rutazioni with Giornata: $giornata");

        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    });

})/* ->add(new AuthenticationMiddleware()) */ ; //* Aggiungi il Middleware di autenticazione a tutto il gruppo
