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
        $result = Formazione::getFormazioniByGiornata($giornata);

        $formazioni = array ();
        foreach ($result as $r) {
            if (!isset ($formazioni[$r->getIdRutatore()]))
                $formazioni[$r->getIdRutatore()] = array ('rutatore' => $r->getRutatore()->toArray());
            if (!isset ($formazioni[$r->getIdRutatore()]['rutazioni']))
                $formazioni[$r->getIdRutatore()]['rutazioni'] = array ();
            // $r->getRutazione()->setBonus_x5($r->getBonus_x5());
            $formazioni[$r->getIdRutatore()]['rutazioni'][] = $r->getRutazione()->toArray();
            $formazioni[$r->getIdRutatore()]['bonus_x2'] = $r->getBonus_x2();
        }

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

    // POST /formazioni/{giornata}
    $group->post('/{giornata}', function (Request $request, Response $response, $args) {
        $giornata = $args['giornata'];
        $data = $request->getParsedBody();

        if (!isset ($data['rutazioni']))
            throw new InvalidArgumentException('Parametri mancanti');

        $rutazioni = json_decode($data['rutazioni']);

        if (count($rutazioni) <= 0)
            throw new InvalidArgumentException('Lista vuota');

        $decodedToken = $request->getAttribute('token');
        $idRutatore = $decodedToken->Id_Rutatore;

        $formazioni = array();
        foreach ($rutazioni as $idRutazione) {
            $formazioni[] = new Formazione($giornata, $idRutatore, $idRutazione, false, false);
        }

        $lastId = Formazione::insertFormazioniByList($formazioni);

        if ($lastId > 0)
            $httpResponse = new HttpResponse(Status::Ok, "INSERT all formazioni to Rutatore", $lastId);
        else
            $httpResponse = new HttpResponse(Status::InternalServerError, "Error INSERT all formazioni to Rutatore");

        $response->getBody()->write($httpResponse->send());
        $response = $response->withStatus($httpResponse->getStatusCode());
        return $response;
    })->add(new AuthenticationMiddleware());

})/* ->add(new AuthenticationMiddleware()) */ ; //* Aggiungi il Middleware di autenticazione a tutto il gruppo
