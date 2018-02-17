<?php

namespace DummyNamespace;

use App\Repositories\DummyRepository;

class DummyService extends BaseService
{
    /**
     * @var DummyRepository
     */
    private $dummyRepository;

    /**
     * DummyService constructor.
     * @param DummyRepository $dummyRepository
     */

    public function __construct(DummyRepository $dummyRepository)
    {
        $this->dummyRepository = $dummyRepository;
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
}