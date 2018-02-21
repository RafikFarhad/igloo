<?php

namespace App\Services;


abstract class BaseService
{

    /**
     * return Repository instance
     *
     * @return mixed
     */
    abstract public function baseRepository();


    /**
     * @return mixed
     */
    public function all()
    {
        return $this->baseRepository()->all();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->baseRepository()->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        return $this->baseRepository()->update($data,$id,$attribute);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id){
        return $this->baseRepository()->delete($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->baseRepository()->find($id,$columns);
    }

    public function getFilterWithPaginatedData(array $filter)
    {
        return $this->baseRepository()->getFilterWithPaginatedData($filter);
    }

}
