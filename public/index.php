<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';

$app = AppFactory::create();

// Rutas para propietarios
require __DIR__ . '/../routes/propietarios.php';

// Rutas para inmuebles
require __DIR__ . '/../routes/inmuebles.php';

$app->run();