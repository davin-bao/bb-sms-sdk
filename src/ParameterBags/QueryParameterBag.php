<?php

namespace DavinBao\DjSms\ParameterBags;

use DavinBao\DjSms\Exceptions\RequiredParameterLackException;

/**
 * Class QueryParameterBag
 * @package DavinBao\DjSms\ParameterBags
 */
class QueryParameterBag extends ParameterBag
{
    /**
     * @var
     */
    protected $requestId;
    /**
     * @var null
     */
    protected $method;
    /**
     * @var null
     */
    protected $module;

    /**
     * QueryParameterBag constructor.
     * @param $requestId
     * @param null $method
     * @param null $module
     */
    public function __construct($requestId, $method = null, $module = null)
    {
        $this->set('requestId', $requestId);
        $this->method = $method;
        $this->module = $module;

        parent::__construct();
    }

    /**
     * @throws RequiredParameterLackException
     */
    public function check()
    {
        $requiredParametersLack = [];

        !$this->requestId && $requiredParametersLack[] = 'requestId';

        if ($requiredParametersLack) {
            throw new RequiredParameterLackException($requiredParametersLack);
        }
    }

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @param mixed $requestId
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }
}