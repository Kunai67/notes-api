<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Middleware\OutputBufferingMiddleware;
use Slim\Routing\RouteCollectorProxy;

include_once __DIR__ . '/controllers/Notes.php';
include_once __DIR__ . '/controllers/Users.php';

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath('/notes-api');

$app->group('/notes', function (RouteCollectorProxy $group) {
    $group->get('/', 'NotesController:read');
    $group->post('/create', 'NotesController:create');
    $group->post('/update', 'NotesController:update');
    $group->post('/delete', 'NotesController:delete');
});

$app->group('/users', function (RouteCollectorProxy $group) {
    $group->get('/', function ($request, $response, $args) {
        $group->get('/', 'UsersController:read');
        $group->post('/create', 'UsersController:create');
        $group->post('/update', 'UsersController:update');
        $group->post('/delete', 'UsersController:delete');
    });
});

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write('Welcome to the API');
    return $response;
});

$app->run();