<?php
namespace App\Middlewares;
use Core\Response;
class AuthMiddleware extends BaseMiddleware {
    public function handle(array $request)
    {
        $response = new Response();
        if(!isset($request['user'])){
            $response->setStatusCode(401)->json([
                'status' => 'error',
                'message' => 'Unauthorized Access is Prohibited!',
                'code' => 401 
            ]);
        }

        return $this->next($request);
    }
}