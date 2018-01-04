<?php

namespace DavinBao\DjSms\ParameterBags;

use DavinBao\DjSms\Exceptions\RequiredParameterLackException;

/**
 * Class TemplateParameterBag
 * @package DavinBao\DjSms\ParameterBags
 */
class TemplateParameterBag extends ParameterBag
{
    /**
     * @var
     */
    protected $code;
    /**
     * @var null
     */
    protected $method;
    /**
     * @var null
     */
    protected $module;

    /**
     * TemplateParameterBag constructor.
     * @param $code
     * @param null $method
     * @param null $module
     */
    public function __construct($code, $method = null, $module = null)
    {
        $this->set('code', $code);
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

        !$this->code && $requiredParametersLack[] = 'code';

        if ($requiredParametersLack) {
            throw new RequiredParameterLackException($requiredParametersLack);
        }
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return null
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param null $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return null
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param null $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }
}