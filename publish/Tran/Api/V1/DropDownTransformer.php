<?php

/**
 * Created with Igloo Generator.
 * Date: 2018-11-09 10:30:57
 */

namespace App\Transformers\Api\V1;

use App\Transformers\ApiTransformerAbstract;

class DropDownTransformer extends ApiTransformerAbstract
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

        if (!array_key_exists('id', $entity)) {
            return [
                'value' => '',
                'text' => 'Select a value'
            ];
        } else {
            return [
                'value' => (int) $entity['id'],
                'text' => $entity['name']
            ];
        }
    }
}
