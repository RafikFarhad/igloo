<?php

namespace App\Repositories;

use App\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 *
 * @package App\Repositories
 */
abstract class Repository
{
    public $recordPerPage = 20;

    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @var
     */
    protected $newModel;

    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract public function model();

    /**
     * Filter data based on user input
     *
     * @param array $filter
     * @param       $query
     */
    abstract public function filterData(array $filter, $query);

    /**
     * Get paginated filtered data.
     *
     * @param array $filter
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getFilterWithPaginatedData(array $filter)
    {
        $query = $this->getQuery();

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }

        return $query->orderBy('id', 'DESC')->paginate($this->recordPerPage);
    }


    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data)->fresh();
    }

    /**
     * @param array  $data
     * @param        $id
     * @param string $attribute
     *
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $model = $this->find($id);
        $model->fill($data);
        $model->save();
        return $model;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * Find resource with relational data
     *
     * @param              $id
     * @param array|string $with
     * @param array        $columns
     *
     * @return mixed
     */
    public function findWith($id, $with, $columns = array('*'))
    {
        if (is_string($with)) {
            $with = [$with];
        }

        return $this->model->with($with)->findOrFail($id, $columns);
    }


    /**
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        return $this->model->all($columns);
    }

    /**
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    public function makeModel()
    {
        return $this->setModel($this->model());
    }

    /**
     * Set Eloquent Model to instantiate
     *
     * @param $eloquentModel
     *
     * @return Model
     * @throws RepositoryException
     */
    public function setModel($eloquentModel)
    {
        $this->newModel = $this->app->make($eloquentModel);

        if (!$this->newModel instanceof Model)
            throw new RepositoryException("Class {$this->newModel} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $this->newModel;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuery()
    {
        return $this->model->newQuery();
    }

    /**
     * @return mixed
     */
    public function getFillable()
    {
        return $this->model->getFillable();
    }

}