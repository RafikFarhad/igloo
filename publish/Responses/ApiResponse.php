<?php

namespace App\Responses;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Contracts\ArrayableInterface;
use Illuminate\Support\Facades\Input;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;

/**
 * Class ApiResponse
 *
 * @package App\Responses
 */
class ApiResponse implements ApiResponseInterface
{

    const HTTP_CODE_200_OK              = 200;
    const HTTP_CODE_201_CREATED         = 201;
    const HTTP_CODE_400_BAD_REQUEST     = 400;
    const HTTP_CODE_401_UNAUTHORIZED    = 401;
    const APP_CODE_200_OK               = 200;
    const APP_CODE_400_INVALID_REQUEST  = 400;

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @param ArraySerializer $serializer
     */
    public function __construct(ArraySerializer $serializer)
    {
        $this->manager = new Manager();
        $this->manager->setSerializer($serializer);
        $this->parseIncludes(Input::get('include'));
    }

    /**
     * Respond success with simple response
     *
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data)
    {
        return response()->json(new SimpleResponse(true, '', $data, self::APP_CODE_200_OK));
    }

    /**
     * Respond error with simple response
     *
     * @param string $message
     * @param string $result
     * @param int $errorCode
     * @param int $applicationCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(
        $message = '',
        $result = '',
        $errorCode = self::HTTP_CODE_400_BAD_REQUEST,
        $applicationCode = self::APP_CODE_400_INVALID_REQUEST
    ) {
        return response()->json(
            new SimpleResponse(false, $message, $result, $applicationCode),
            $errorCode
        );
    }

    /**
     * @param $includes
     * @internal param $connection
     * @return mixed
     */
    public function parseIncludes($includes)
    {
        if (is_null($includes)) {
            return false;
        }

        $this->manager->parseIncludes($includes);
    }

    /**
     * @param mixed $data
     * @param \League\Fractal\TransformerAbstract|callable $transformer
     * @param string $resourceKey
     * @return array
     */
    public function item($data, $transformer = null, $resourceKey = null)
    {
        $resource = new Item($data, $this->getTransformer($transformer), $resourceKey);

        $result = $this->manager->createData($resource)->toArray();

        return response()->json(new SimpleResponse(true, '', $result, self::HTTP_CODE_200_OK));
    }

    /**
     * @param $data
     * @param \League\Fractal\TransformerAbstract|callable $transformer
     * @param string $resourceKey
     * @return array
     */
    public function collection($data, $transformer = null, $resourceKey = null)
    {
        $resource = new Collection($data, $this->getTransformer($transformer), $resourceKey);

        $result = $this->manager->createData($resource)->toArray();

        return response()->json(new SimpleResponse(true, '', $result['data'], self::APP_CODE_200_OK));
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param \League\Fractal\TransformerAbstract|callable $transformer
     * @param string $resourceKey
     * @return mixed
     */
    public function paginatedCollection(LengthAwarePaginator $paginator, $transformer = null, $resourceKey = null)
    {
        $paginator->appends(\Request::query());
        $resource = new Collection($paginator->getCollection(), $this->getTransformer($transformer), $resourceKey);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        $result = $this->manager->createData($resource)->toArray();

        return response()->json(new SimpleResponse(true, '', $result, self::APP_CODE_200_OK));
    }

    /**
     * @param TransformerAbstract $transformer
     * @return TransformerAbstract|callback
     */
    protected function getTransformer($transformer = null)
    {
        return $transformer ?: function ($data) {
            if ($data instanceof ArrayableInterface) {
                return $data->toArray();
            }
            return (array)$data;
        };
    }
}