<?php namespace App\Transformers;

interface TransformableFieldInterface
{
    /**
     * Get the fields to be transformed.
     *
     * @param $entity
     *
     * @return mixed
     */
    public function getTransformableFields($entity);

}