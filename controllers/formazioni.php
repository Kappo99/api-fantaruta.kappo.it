<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Crea un'applicazione per gli utenti
$app->group('/formazioni', function ($group) {

    // GET /formazioni
    $group->get('', function (Request $request, Response $response) {

        $httpResponse = new HttpResponse(Status::NotImplemented, "GET all formazioni");
        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    });

    // GET /formazioni/{giornata}
    $group->get('/{giornata}', function (Request $request, Response $response, $args) {
        $giornata = $args['giornata'];
        $formazioni = Formazione::getFormazioniByGiornata($giornata);

        // $formazioni = array();
        // foreach ($result as $r) {
        //     if (!isset($formazioni[$r['IdRutatore']]))
        //         $formazioni[$r['IdRutatore']] = array('rutatore' => $r['Rutatore']->toArray());

        // }

        if ($formazioni)
            $httpResponse = new HttpResponse(
                Status::Ok,
                "GET all formazioni with Giornata: $giornata",
                array ('formazioni' => $formazioni)
            );
        else
            $httpResponse = new HttpResponse(Status::NotFound, "Not Found formazioni with Giornata: $giornata");

        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    });

})/* ->add(new AuthenticationMiddleware()) */ ; //* Aggiungi il Middleware di autenticazione a tutto il gruppo
