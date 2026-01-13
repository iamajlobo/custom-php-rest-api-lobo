<?php

namespace App\Controllers;

use Core\Request;
use Core\Response;
use App\Services\TestService;
use App\Requests\TestRequest;
use App\Repositories\TestRepository;
use App\Responses\TestResponse;

class TestController extends BaseController{
    private TestResponse $test_response;
    private TestService $test_service;
    private TestRequest $test_request;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
        $this->test_response = new TestResponse($response);
        $this->test_service = new TestService(new TestRepository(),$response,$this->test_response);
        $this->test_request =new TestRequest();
    }

    public function index() : void
    {
        $data = $this->test_service->retrieveData();
        $this->test_response->success('Data Successfully Retrieved!',200,['users'=>$data]);
    }

    public function show($params) : void
    {
        
    }

    public function store() : void
    {
        $data = $this->test_request->validated();
        $id = $this->test_service->register($data);
        $this->test_response->success('Stored Successfully',201,['user'=>$id]);
    }

    public function update($params) : void
    {
        echo "From TestController Update: {$params[0]}";
    }

    public function destroy($params) : void
    {
        echo "From TestController Destroy: {$params[0]}";
    }
}