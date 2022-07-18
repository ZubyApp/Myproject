<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\App;
use App\Router;
use App\Config;
use App\Container;
use App\Controllers\TransactionController;
use App\Model\Transaction;
use App\Models\Transaction as ModelsTransaction;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('STORAGE_PATH', __DIR__ . '/../storage');
define('FILE_PATH', __DIR__ . '/../storage/');
define('VIEW_PATH', __DIR__ . '/../views');

$container = new Container();
$router    = new Router($container);

$router 
    ->get('/', [HomeController::class, 'index'])
    ->get('/transactions', [TransactionController::class, 'viewTransactions'])
    ->get('/savetransaction', [TransactionController::class, 'saveTransaction'])
    ->post('/upload', [HomeController::class, 'saveFile']);


(new App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();