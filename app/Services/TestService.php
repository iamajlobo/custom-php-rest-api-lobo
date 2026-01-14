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
        $is_exist = $this->repository->findByEmail($data['email']);
        if($is_exist) $this->test_response->error('Email Already Exist!',400);
        $test = new Test($data);
        $id = $this->repository->create($test->getTest());
        return $id;
    }

    public function retrieveData() : array
    {
        $data = $this->repository->read();
        if(empty($data)) $this->test_response->error('No Data Found!',200);
        return $data;
    }

    public function retrieveById(int $id) : array
    {
        $data = $this->repository->findById($id);
        if(empty($data)) $this->test_response->error('No Data Found',200);
        return $data;
    }


    public function updateById(int $id,array $data) : bool
    {
        $is_exist = $this->repository->findById($id);
        if(!$is_exist) $this->test_response->error("Data not exist!",200);
        $test = new Test($data);
        $success = $this->repository->update($id,$test->getTest());
        if(!$success) $this->test_response->error('Not Updated',400);
        return $success;
    }

    public function deleteByID(int $id) : bool
    {   
        $is_exist = $this->repository->findById($id);
        if(!$is_exist) $this->test_response->error("Data not exist!",200);
        $success = $this->repository->delete($id);
        return $success;
    }

}