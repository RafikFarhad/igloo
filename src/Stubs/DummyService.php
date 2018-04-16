<?php

namespace DummyNamespace;

/**
 * Created by Igloo Generator.
 * Date: DUMMYDATE
 */

use App\Repositories\DummyRepository;
use App\Responses\ApiResponse;
use App\Transformers\Api\DummyTransformer;
use Exception;

class DummyService extends BaseService
{
    /**
     * @var DummyRepository
     */
    private $dummyRepository;
    /**
     * @var ApiResponse
     */
    private $apiResponse;

    /**
     * DummyService constructor.
     * @param DummyRepository $dummyRepository
     * @param ApiResponse $apiResponse
     */
    public function __construct(DummyRepository $dummyRepository, ApiResponse $apiResponse)
    {
        $this->dummyRepository = $dummyRepository;
        $this->apiResponse = $apiResponse;
    }

    /**
     * return Repository instance
     *
     * @return mixed
     */
    public function baseRepository()
    {
        return $this->dummyRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function allDummys()
    {
        try {
            $dummys = $this->dummyRepository->getFilterWithPaginatedData([]);
            return $this->apiResponse->withPaginator($dummys, new DummyTransformer());
        } catch (Exception $e) {
            return $this->apiResponse->withError('Something Went Wrong.', 422);
        }
    }

    /**
     * @param DummyCreateRequest $request
     * @return mixed
     */
    public function createDummy($request)
    {
        try {
            $data = $request->only(
                [
                    /*FILLABLE*/
                ]
            );
            $dummy = $this->dummyRepository->create($data);
            return $this->apiResponse->withItem($dummy, new DummyTransformer());
        } catch (Exception $e) {
            return $this->apiResponse->withError('Something Went Wrong.', 422);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function FindDummy($id)
    {
        try {
            $dummy = $this->dummyRepository->find($id);
            return $this->apiResponse->withItem($dummy, new DummyTransformer());
        } catch (Exception $exception) {
            return $this->apiResponse->errorNotFound('Dummy Not Found');
        }
    }

    /**
     * @param $id
     * @param DummyCreateRequest $request
     * @return mixed
     */
    public function updateDummy($id, $request)
    {
        try {
            $data = $request->only(
                [
                    /*FILLABLE*/
                ]
            );

            $dummy = $this->dummyRepository->update($data, $id);
            return $this->apiResponse->withItem($dummy, new DummyTransformer());
        } catch (Exception $e) {
            return $this->apiResponse->errorNotFound('Dummy not found');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function deleteDummy($id)
    {
        try {
            $dummy = $this->dummyRepository->delete($id);
            if ($dummy) {
                return $this->apiResponse->message('Dummy deleted Successfully');
            }
            return $this->apiResponse->errorNotFound('Dummy Not Found');
        } catch (Exception $e) {
            return $this->apiResponse->errorNotFound('Dummy Not Found');
        }
    }
}
