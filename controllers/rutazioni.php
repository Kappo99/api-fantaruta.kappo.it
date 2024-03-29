<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Crea un'applicazione per gli utenti
$app->group('/rutazioni', function ($group) {

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
        $result = Rutazione::getRutazioniByGiornata($giornata);

        $rutazioni = $result[0];
        $count = $result[1];
        $numRutate = $result[2];

        for ($i = 0; $i < count($rutazioni); $i++) {
            $rutazioni[$i] = $rutazioni[$i]->toArray();
        }

        if ($rutazioni)
            $httpResponse = new HttpResponse(
                Status::Ok,
                "GET all rutazioni with Giornata: $giornata",
                array ('rutazioni' => $rutazioni, 'count' => $count, 'numRutate' => $numRutate)
            );
        else
            $httpResponse = new HttpResponse(Status::NotFound, "Not Found rutazioni with Giornata: $giornata");

        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    });

    // GET /rutazioni/{id}/count
    $group->get('/{id}/count', function (Request $request, Response $response, $args) {
        $id = $args['id'];
        $count = Rutazione::getRutazioniCountById($id);

        $httpResponse = new HttpResponse(
            Status::Ok,
            "GET rutazioni Count with Id: $id",
            array ('count' => $count)
        );

        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    });

    // GET /rutazioni/{id}
    $group->put('/{id}', function (Request $request, Response $response, $args) {
        $id = $args['id'];
        $updated = Rutazione::updateIsRutataById($id);

        if ($updated > 0)
            $httpResponse = new HttpResponse(
                Status::Ok,
                "UPDATE Rutazione $id isRutata status",
                $updated
            );
        else
            $httpResponse = new HttpResponse(Status::InternalServerError, "Not UPDATE Rutazione $id isRutata status");

        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    })->add(new AuthenticationMiddleware());

})/* ->add(new AuthenticationMiddleware()) */ ; //* Aggiungi il Middleware di autenticazione a tutto il gruppo
