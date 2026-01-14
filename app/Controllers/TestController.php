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

    public function show(array $params) : void
    {
        $data = $this->test_service->retrieveById($params[0]);
        $this->test_response->success('Data Successfully Retrieved!',200,['users'=>$data]);
    }

    public function store() : void
    {
        $data = $this->test_request->validated();
        $id = $this->test_service->register($data);
        $this->test_response->success('Stored Successfully',201,['user'=> ['id'=>$id]]);
    }

    public function update(array $params) : void
    {
        $data = $this->test_request->validated();
        $this->test_service->updateByID($params[0],$data);
        $this->test_response->success('Updated Successfully',200);
    }

    public function destroy(array $params) : void
    {
        $this->test_service->deleteByID($params[0]);
        $this->test_response->success('Deleted Successfully',200);
    }

    public function login() {
        print_r("Gello");
    }
}