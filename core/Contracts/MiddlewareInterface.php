<?php

namespace Core\Contracts;

interface MiddlewareInterface {
    public function setNext(MiddlewareInterface $handler) : MiddlewareInterface;
    public function handle(array $request);
}