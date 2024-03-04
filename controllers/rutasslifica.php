<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Crea un'applicazione per gli utenti
$app->group('/rutasslifica', function ($group) {

    // GET /rutasslifica
    $group->get('', function (Request $request, Response $response, $args) {
        $rutasslifica = Rutasslifica::getRutasslifica();

        // for ($i = 0; $i < count($rutasslifica); $i++) {
        //     $rutasslifica[$i] = $rutasslifica[$i]->toArray();
        // }

        if ($rutasslifica)
            $httpResponse = new HttpResponse(
                Status::Ok,
                "GET all rutasslifica",
                array ('rutasslifica' => $rutasslifica)
            );
        else
            $httpResponse = new HttpResponse(Status::NotFound, "Not Found rutasslifica");

        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    });

})/* ->add(new AuthenticationMiddleware()) */ ; //* Aggiungi il Middleware di autenticazione a tutto il gruppo
