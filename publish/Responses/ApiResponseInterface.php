<?php

namespace App\Responses;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface ApiResponseInterface
 *
 * @package App\Responses
 */
interface ApiResponseInterface
{
    /**
     * @param $includes
     * @internal param $connection
     * @return mixed
     */
    public function parseIncludes($includes);

    /**
     * @param mixed $data
     * @param \League\Fractal\TransformerAbstract|callable $transformer
     * @param string $resourceKey
     * @return array
     */
    public function item($data, $transformer = null, $resourceKey = null);

    /**
     * @param $data
     * @param \League\Fractal\TransformerAbstract|callable $transformer
     * @param string $resourceKey
     * @return array
     */
    public function collection($data, $transformer = null, $resourceKey = null);

    /**
     * @param LengthAwarePaginator $paginator
     * @param \League\Fractal\TransformerAbstract|callable $transformer
     * @param string $resourceKey
     * @return mixed
     */
    public function paginatedCollection(LengthAwarePaginator $paginator, $transformer = null, $resourceKey = null);
}