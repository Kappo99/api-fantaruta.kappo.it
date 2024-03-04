<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Crea un'applicazione per gli utenti
$app->group('/rutabonus', function ($group) {

    // GET /rutabonus
    $group->get('', function (Request $request, Response $response, $args) {
        $rutabonus = RutaBonus::getRutaBonus();

        for ($i = 0; $i < count($rutabonus); $i++) {
            $rutabonus[$i] = $rutabonus[$i]->toArray();
        }

        if ($rutabonus)
            $httpResponse = new HttpResponse(
                Status::Ok,
                "GET all rutabonus with ",
                array ('rutabonus' => $rutabonus)
            );
        else
            $httpResponse = new HttpResponse(Status::NotFound, "Not Found rutabonus");

        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    });

})/* ->add(new AuthenticationMiddleware()) */ ; //* Aggiungi il Middleware di autenticazione a tutto il gruppo
