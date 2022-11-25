<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/dbconnect.php';

$app = AppFactory::create();

// $app->get('/{name}', function (Request $request, Response $response, array $args) {
//     $name = $args['name'];
//     $response->getBody()->write("Hello, $name");
//     return $response;
// });

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello, Rajib");
    return $response;
});

require __DIR__ . '/../app/routes.php';
$app->run();