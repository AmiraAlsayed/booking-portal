<?php

namespace App\Repositories;

/**
 * Interface RepositoryInterface
 * @package App\Repositories
 */
interface RepositoryInterface {

    public function all($columns = array('*'));

    public function where($scopes = [], $columns = array('*'));

    public function create(array $data);

    public function find($id, $columns = array('*'));
}
