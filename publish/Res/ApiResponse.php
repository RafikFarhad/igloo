<?php
/**
 * Created by PhpStorm.
 * User: rat
 * Date: 2/9/18
 * Time: 10:06 AM
 */

namespace App\Responses;

use EllipseSynergie\ApiResponse\AbstractResponse;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Validation\Validator;
use League\Fractal\Resource\Collection;

class ApiResponse extends AbstractResponse
{
    /**
     * @param array $array
     * @param array $headers
     * @param int $json_options
     * @return \Illuminate\Http\JsonResponse
     */
    public function withArray(array $array, array $headers = [], $json_options = 0)
    {
        return response()->json($array, $this->statusCode, $headers, $json_options);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function message($message)
    {
        return $this->withArray(['message' => $message]);
    }

    /**
     * @param $message
     * @param $statusCode
     * @param array $headers
     * @return mixed
     */
    public function withErrorAndStatus($message, $statusCode, array $headers = [])
    {
        return $this->setStatusCode($statusCode)->withError($message, "", $headers);
    }

    public function withPaginator(LengthAwarePaginator $paginator, $transformer, $resourceKey = null, $meta = [])
    {
        $queryParams = array_diff_key($_GET, array_flip(['page']));
        $paginator->appends($queryParams);

        $resource = new Collection($paginator->items(), $transformer, $resourceKey);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        foreach ($meta as $metaKey => $metaValue) {
            $resource->setMetaValue($metaKey, $metaValue);
        }

        $rootScope = $this->manager->createData($resource);

        return $this->withArray($rootScope->toArray());
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message from validator
     *
     * @param Validator $validator
     * @return ResponseFactory
     */
    public function errorWrongArgsValidator(Validator $validator)
    {
        return $this->errorWrongArgs($validator->getMessageBag()->toArray());
    }
}
