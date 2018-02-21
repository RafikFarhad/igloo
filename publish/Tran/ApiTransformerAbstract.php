<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

abstract class ApiTransformerAbstract extends TransformerAbstract implements TransformableFieldInterface
{

    public function transform($entity)
    {
        $transformableFields = $this->getTransformableFields($entity);

        if (!method_exists($this, 'getExtraTransformableFields')) {
            return $transformableFields;
        }

        $extraTransformableFields = $this->getExtraTransformableFields($entity);

        if (empty($extraTransformableFields)) {
            return $transformableFields;
        }

        return array_merge($transformableFields, $extraTransformableFields);
    }

    /**
     * Get the fields to be transformed.
     *
     * @param $entity
     *
     * @return mixed
     */
    abstract public function getTransformableFields($entity);
}