<?php
namespace App\Services;
use App\Models\Test;
use App\Repositories\TestRepository;
use App\Responses\TestResponse;
use Core\Response;

class TestService {
    
    public function __construct(private TestRepository $repository,private Response $response,private TestResponse $test_response){}

    public function register(array $data) : int 
    {
        $check_email = $this->repository->findByEmail($data['email']);
        if($check_email) $this->test_response->error('Email Already Exist!',400);
        $test = new Test($data);
        $id = $this->repository->create($test->getTest());
        return $id;
    }

    public function retrieveData() : array
    {
        $data = $this->repository->read();
        if(empty($data)) $this->test_response->success('No Data Found!',204);
        return $data;
    }


}