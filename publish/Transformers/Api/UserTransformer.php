<?php

namespace App\Transformers\Api;

use App\Transformers\ApiTransformerAbstract;

class UserTransformer extends ApiTransformerAbstract
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
        return [
            'user_id' => (int)$entity->id,
            'name' => $entity->name,
            'email' => $entity->email,
        ];
    }
}