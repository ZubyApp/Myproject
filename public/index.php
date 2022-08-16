<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\App;
use App\Router;
use App\Controllers\InvoiceController;
use Illuminate\Container\Container;

require_once __DIR__ . '/../vendor/autoload.php';

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

$container = new Container();
$router    = new Router($container);

$router->registerRoutesFromControllerAttributes(
    [
        HomeController::class,
        InvoiceController::class,
    ]
);

echo '<pre>';
var_dump($_ENV);
echo '</pre>';

(new App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]
))->boot()->run();

echo '<pre>';
var_dump($_ENV);
echo '</pre>';
