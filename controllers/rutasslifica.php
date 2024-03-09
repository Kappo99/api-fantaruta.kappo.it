<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Crea un'applicazione per gli utenti
$app->group('/rutasslifica', function ($group) {

    // GET /rutasslifica
    $group->get('', function (Request $request, Response $response, $args) {
        $rutasslifica = Rutasslifica::getRutasslifica();

        for ($i = 0; $i < count($rutasslifica); $i++) {
            $rutasslifica[$i] = $rutasslifica[$i]->toArray();
        }

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

    // GET /rutasslifica/{giornata}
    $group->get('/{giornata}', function (Request $request, Response $response, $args) {
        $giornata = $args['giornata'];
        $result = Rutasslifica::getRutasslificaByGiornata($giornata);

        $rutasslifica = $result[0];
        $rutasslificaPrev = $result[1];

        for ($i = 0; $i < count($rutasslifica); $i++) {
            $rutasslifica[$i] = $rutasslifica[$i]->toArray();
        }

        for ($i = 0; $i < count($rutasslificaPrev); $i++) {
            $rutasslificaPrev[$i] = $rutasslificaPrev[$i]->toArray();
        }

        if ($rutasslifica)
            $httpResponse = new HttpResponse(
                Status::Ok,
                "GET all rutasslifica",
                array ('rutasslifica' => $rutasslifica, 'rutasslificaPrev' => $rutasslificaPrev)
            );
        else
            $httpResponse = new HttpResponse(Status::NotFound, "Not Found rutasslifica");

        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    });

})/* ->add(new AuthenticationMiddleware()) */ ; //* Aggiungi il Middleware di autenticazione a tutto il gruppo
