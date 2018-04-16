<?php

/**
 * Created by Igloo Generator.
 * Date: DUMMYDATE
 */

namespace DummyNamespace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dummy\CreateRequest as DummyRequest;
use App\Http\Requests\Api\Dummy\UpdateRequest as DummyUpdateRequest;
use App\Services\DummyService;

class DummyController extends Controller
{
    private $dummyService;

    public function __construct(DummyService $dummyService)
    {
        $this->dummyService = $dummyService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function index()
    {
        return $this->dummyService->allDummys();
    }

    /**
     * @param DummyCreateRequest $request
     * @return mixed
     */
    public function create(DummyRequest $request)
    {
        return $this->dummyService->createDummy($request);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->dummyService->findDummy($id);
    }


    /**
     * @param $id
     * @param DummyCreateRequest $request
     * @return mixed
     */
    public function update($id, DummyUpdateRequest $request)
    {
        return $this->dummyService->updateDummy($id, $request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function delete($id)
    {
        return $this->dummyService->deleteDummy($id);
    }
}
