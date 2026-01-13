<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

use Core\Exceptions\ErrorHandler;
use Core\Router;

set_error_handler([ErrorHandler::class,'handleError']);
set_exception_handler([ErrorHandler::class,'handleException']);

$router = new Router();
require_once __DIR__ . '/../app/Routes/api.php';
$router->dispatch();