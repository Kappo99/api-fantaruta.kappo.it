<?php

use Slim\Factory\AppFactory;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/configs/config.php';

require_once __DIR__ . '/include/utilities.php';

require_once __DIR__ . '/include/model.php';

// Inizializza il tuo framework o gestisci le richieste manualmente
$app = AppFactory::create();

// Aggiungi il middleware di gestione degli errori
$app->add(new ErrorMiddleware());

// Includi le rotte per gli utenti
require_once __DIR__ . '/include/controllers.php';

$app->run();

