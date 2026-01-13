<?php
namespace App\Controllers;
use Core\Request;
use Core\Response;

class BaseController {
    public function __construct(protected Request $request, protected Response $response){}

}
