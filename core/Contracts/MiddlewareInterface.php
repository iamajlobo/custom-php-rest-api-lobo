<?php

namespace Core\Contracts;
// Create a contract for all Middlewares
interface MiddlewareInterface {
    public function setNext(MiddlewareInterface $handler) : MiddlewareInterface;
    public function handle(array $request);
}