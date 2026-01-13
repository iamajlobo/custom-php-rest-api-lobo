<?php
namespace App\Middlewares;
use Core\Contracts\MiddlewareInterface;

abstract class BaseMiddleware implements MiddlewareInterface {
    protected ?MiddlewareInterface $next = null;

    public function setNext(MiddlewareInterface $handler): MiddlewareInterface
    {
        $this->next = $handler;
        return $handler;
    }

    public function next(array $request)
    {
        if($this->next){
            return $this->next->handle($request);
        }
        return null;
    }
}