<?php
namespace App\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

const DEFAULT_PER_PAGE = 10;

/**
 * Class Repository
 * @package App\Repositories\Eloquent
 */
abstract class BaseRepository implements RepositoryInterface {

    /**
     * @var App
     */
    private $app;

    /**
     * @var Model $model
     */
    protected $model;

    /**
     * Repository constructor.
     * @param App $app
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel() {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            // throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
            dd('Not a model');
        return $this->model = $model;
    }

    /**
     * GEt the model of this repository
     *
     * @return Model
     */
    public function getModel(){
        return $this->model;
    }

    /**
     * get all the records of a model
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    /**
     * get model records that matches specific conditions
     * with the ability to get specific columns and also paginate results
     * @param array $scopes
     * @param array $columns
     * @param bool $paginateResult
     * @param int $perPage
     * @return mixed
     */
    public function where(
        $scopes = [],
        $columns = array('*'),
        $paginateResult = false,
        $perPage = DEFAULT_PER_PAGE
    )
    {
        $query = $this->buildQuery($this->model, $scopes, $columns);
        if($paginateResult)
            return $query->paginate($perPage, $columns);
        return $query->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = DEFAULT_PER_PAGE, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * create a new model record in the DB
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * update an existing model record in the DB
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute='id')
    {
        if (empty($data)){
            throw new \InvalidArgumentException('Request data can not be empty', 400);
        }

        if($id === 'id') {
            $item = $this->find($id);
            if($item) {
                return $item->update($data);
            } else {
                throw new ModelNotFoundException('Record not found', 404);
            }
        } else {
            $item = $this->findBy($attribute, $id);
            if($item) {
                return $item->update($data);
            } else {
                throw new ModelNotFoundException('Record not found', 404);
            }
        }
    }

    /**
     * delete a model record from the DB
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * find a model record by id
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * ind a model record by a field
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*')) {
        $record = $this->model->where($attribute, '=', $value)->first($columns);
        if(! $record) {
            throw new ModelNotFoundException('Record not found', 404);
        }

        return $record;
    }

    /**
     * get a model with one or more relational models
     * @param $relation
     * @param bool $all
     * @return mixed
     */
    public function with($relation, $all = false)
    {
        //TODO Amr: refactor this function to use relations as an array not single string
        if($all) {
            return $this->model->with($relation)->get();
        }
        return $this->model->with($relation)->paginate(DEFAULT_PER_PAGE);
    }

    /**
     * select a model with one or more relational models
     * and with a specific criteria.
     * @param $relations
     * @param $scopes
     * @param array $columns
     * @param bool $paginateResult
     * @param int $perPage
     * @return mixed
     */
    public function selectWithRelationAndCriteria(
        $relations,
        $scopes,
        $columns = array('*'),
        $paginateResult = false,
        $perPage = DEFAULT_PER_PAGE
    )
    {
        /*
         $query =  $this->model->with([$relation => function($q) use ($scopes, $paginateResult, $perPage){
            $this->buildQuery($q, $scopes);
        }]);
        if($paginateResult)
            return $query->paginate($perPage, $columns);
        return $query->get($columns);*/
        $query = $this->buildQuery($this->model, $scopes, $columns);
        // if($paginateResult)
            //  $query->with($relation)->paginate($perPage, $columns);
        // return $query->with($relation)->get($columns);
        if($paginateResult)
            return call_user_func_array( array( $query, 'with' ), $relations )->paginate($perPage, $columns);
        return call_user_func_array( array( $query, 'with' ), $relations )->get($columns);

    }

    /**
    * Append queries to get required model
     * @param $query
     * @param $scopes
     * @param $columns
     * @return mixed
     */
    private function buildQuery($query, $scopes, $columns) {

        if (empty($scopes))
            return $query;

        if(array_key_exists('q', $scopes)) {
            if(! array_key_exists('q_field', $scopes))
                throw new HttpException(400, 'Invalid request data');

            $query = $query->where($scopes['q_field'], 'LIKE', '%'.$scopes['q'].'%');

            // remove the q and q_field keys from the fields to be filters with in the DB
            unset($scopes['q']);
            unset($scopes['q_field']);
        }

        foreach($scopes as $scope => $value)
            if(! in_array($scope, ['near_by', 'lat', 'long'])) $query = $query->where($scope, $value);

        if(array_key_exists('near_by', $scopes)) {
            if(! array_key_exists('lat', $scopes) || ! array_key_exists('long', $scopes)) {
                throw new HttpException(400, 'Invalid request data');
            }
            $query = $query->nearBy($scopes['lat'], $scopes['long'], $columns, true);
        } else {
            if( array_key_exists('lat', $scopes) && array_key_exists('long', $scopes)) {
                $query = $query->nearBy($scopes['lat'], $scopes['long'], $columns, false);
            }
        }
        return $query;
    }


}
