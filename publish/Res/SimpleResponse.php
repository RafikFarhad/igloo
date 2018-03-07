<?php

namespace App\Responses;


/**
 * Class SimpleResponse
 *
 * @package App\Responses
 */
class SimpleResponse
{
    /** @var string bool */
    public $success;

    /** @var string error message */
    public $error;

    /** @var integer */
    public $status;

    /** @var object */
    public $data;

    /**
     * @param bool   $success
     * @param string $error
     * @param string $result
     * @param string $errorCode
     */
    public function __construct($success = false, $error = '', $result = '', $errorCode = '')
    {
        $this->success = $success;
        $this->error = $error;
        $this->data = $result;
        $this->status = $errorCode;
    }

    /**
     * Set Error description
     *
     * @param string $error
     *
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * Get Error description
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set error code
     *
     * @param $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get error code
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set Result object
     *
     * @param $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get Result object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set success status
     *
     * @param bool $success
     *
     * @return $this
     */
    public function setSuccess($success)
    {
        $this->success = $success;
        return $this;
    }

    /**
     * Get success status
     * @return bool
     */
    public function getSuccess()
    {
        return $this->success;
    }
}
