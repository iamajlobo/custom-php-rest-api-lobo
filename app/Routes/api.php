<?php
use App\Controllers\TestController;
use App\Middlewares\RoleMiddleware;
use App\Middlewares\TestMiddleware;
use App\Middlewares\AuthMiddleware;

$router->get('/',[TestController::class,'index'],[TestMiddleware::class]);

$router->get('/api/test',[TestController::class,'index']);
$router->get('/api/test/{id}',[TestController::class,'show'],[TestMiddleware::class]);
$router->post('/api/test',[TestController::class,'store'],[TestMiddleware::class]);
$router->put('/api/test/{id}',[TestController::class,'update'],[TestMiddleware::class]);
$router->patch('/api/test/{id}',[TestController::class,'update'],[TestMiddleware::class]);
$router->delete('/api/test/{id}',[TestController::class,'destroy'],[TestMiddleware::class]);

$router->post('/api/users',[TestController::class,'login'],[AuthMiddleware::class]);
