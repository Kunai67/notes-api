<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Middleware\OutputBufferingMiddleware;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath('/notes-api');

$app->group('/notes', function (RouteCollectorProxy $group) {
    $group->get('/', function ($request, $response, $args) {
        
    });
});

$app->group('/users', function (RouteCollectorProxy $group) {
    $group->get('/', function ($request, $response, $args) {
        
    });
});

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write('Welcome to the API');
    return $response;
});

$app->run();