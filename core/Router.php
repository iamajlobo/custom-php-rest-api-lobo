<?php

namespace Core;
class Router {
    private array $routes = [];
    private Request $request;
    private Response $response;
    
    public function __construct() { $this->request = new Request(); $this->response = new Response();}

    private function add(string $method, string $path,$handler,array $middleware = []) : void
    {
        $this->routes[$method][$path] = ['handler' => $handler, 'middleware' => $middleware]; 
    }

    public function get(string $path, $handler,array $middleware = []) : void
    {
        $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path,$handler,array $middleware = []) : void
    {
        $this->add('POST', $path, $handler, $middleware);
    }


    public function put(string $path,$handler,array $middleware = []) : void
    {
        $this->add('PUT', $path, $handler, $middleware);
    }


    public function patch(string $path,$handler,array $middleware = []) : void
    {
        $this->add('PATCH', $path, $handler, $middleware);
    }


    public function delete(string $path,$handler,array $middleware = []) : void
    {
        $this->add('DELETE', $path, $handler, $middleware);
    }

    public function dispatch() : void
    {
        $method = $this->request->method();
        $current_path = $this->request->path();

        if(!isset($this->routes[$method])){
            $this->response->setStatusCode(404)->json([
                'status' => 'error',
                'message' => 'Not Found',
                'code' => 404
            ]);
        }

        foreach($this->routes[$method] as $path => $route){
            $pattern = preg_replace("#\{[\w]+}#","([\w-]+)",$path);
            $pattern = "#^{$pattern}$#";

            if(preg_match($pattern,$current_path,$params)){
                array_shift($params);
                ['handler' => $handler,'middleware' => $middleware] = $route;
                if(!empty($middleware)) $this->runMiddlewares($this->request->user(),$middleware);    
                $this->call($handler, $params);
                exit;
            }
        }
        
        $this->response->setStatusCode(404)->json([
            'status' => 'error',
            'message' => 'Not Found',
            'code' => 404
        ]);
    }

    private function call(array $handler, array $params) : void
    {
        [$controller,$action] = $handler;
        $instance = new $controller($this->request,$this->response);
        call_user_func([$instance,$action],$params);
    }

    private function runMiddlewares(array $request,array $middleware = []) : void
    {
        $instances =  array_map(fn($class)=> new $class(),$middleware);

        $first = null;
        $previous = null;

        foreach($instances as $mw){
            if($previous){
                $previous->setNext($mw);
            }else{
                $first = $mw;
            }
            $previous = $mw;
        }

        $first->handle($request);
    }

}
