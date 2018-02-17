<?php

/**
 * Created by Igloo Generator.
 * Date: DUMMYDATE
 */

namespace DummyNamespace;

use App\Transformers\ApiTransformerAbstract;

class DummyTransformer extends ApiTransformerAbstract
{

    /**
     * Get the fields to be transformed.
     *
     * @param $entity
     *
     * @return mixed
     */
    public function getTransformableFields($entity)
    {
        return [/*DummyColumnValues*/
        ];
    }
}
