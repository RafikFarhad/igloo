<?php

/**
 * Created by Igloo Generator.
 * Date: DUMMYDATE
 */

namespace DummyNamespace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DummyRequest;
use App\Responses\ApiResponse;
use App\Services\DummyService;
use App\Transformers\Api\DummyTransformer;
use Illuminate\Http\Request;

class DummyController extends Controller
{
    private $dummyService;
    private $apiResponse;

    public function __construct(DummyService $dummyService,
                                ApiResponse $apiResponse)
    {
        $this->dummyService = $dummyService;
        $this->apiResponse = $apiResponse;
    }

    public function index()
    {
        try
        {
            $dummy_plural = $this->dummyService->getFilterWithPaginatedData([]);
//            return fractal()->collection($dummy_plural, new DummyTransformer());
            return $this->apiResponse->withPaginator($dummy_plural, new DummyTransformer());
        }
        catch (\Exception $e)
        {
            return $this->apiResponse->withError('Something Went Wrong.', 422);
        }
    }

    public function create(DummyRequest $request)
    {
        try
        {
            $data = $request->only([/*FILLABLE*/]);
            $dummy = $this->dummyService->create($data);
            return $this->apiResponse->withItem($dummy, new DummyTransformer());
        }
        catch (\Exception $e)
        {
            return $this->apiResponse->withError('Something Went Wrong.', 422);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $id = $request->id;
            $data = $request->only([/*FILLABLE*/]);
            $dummy = $this->dummyService->update($data, $id);
            if($dummy)
            {
                return $this->apiResponse->withItem($dummy, new DummyTransformer());
            }
            throw new \Exception();
        }
        catch (\Exception $e)
        {
            return $this->apiResponse->withError('Something Went Wrong.', 422);
        }
    }

    public function delete(Request $request)
    {
        try
        {
            $id = $request->id;
            $dummy = $this->dummyService->delete($id);
            if($dummy)
            {
                return $this->apiResponse->message('Deleted');
            }
            throw new \Exception();
        }
        catch (\Exception $e)
        {
            return $this->apiResponse->withError('Something Went Wrong.', 422);
        }
    }
}
