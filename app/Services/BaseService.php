<?php
namespace App\Services;

use Illuminate\Http\Request;
use Validator;
const DEFAULT_PER_PAGE = 10;

/**
 * Class Service
 * @package App\Service
 */
abstract class BaseService implements ServiceInterface {

    public function where($scopes = [], $columns = ['*']){
        return $this->repository->where($scopes, $columns);
    }

    public function show($id){
        return $this->repository->find($id);
    }

    public function all() {
        return $this->repository->all();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request) {
        $data = $request->all();
        return $this->repository->create($data);
    }
}
