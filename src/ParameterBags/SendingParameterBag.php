<?php

namespace DavinBao\DjSms\ParameterBags;

use DavinBao\DjSms\Exceptions\ParameterValueErrorException;
use DavinBao\DjSms\Exceptions\RequiredParameterLackException;

/**
 * Class SendingParameterBag
 * @package DavinBao\DjSms\ParameterBags
 */
class SendingParameterBag extends ParameterBag
{
    /**
     * @var
     */
    protected $signName;
    /**
     * @var
     */
    protected $templateCode;
    /**
     * @var
     */
    protected $mobile;
    /**
     * @var array
     */
    protected $parameters;
    /**
     * @var
     */
    protected $method;
    /**
     * @var
     */
    protected $module;
    /**
     * @var
     */
    protected $path;

    /**
     * SendingParameterBag constructor.
     * @param $signName
     * @param $templateCode
     * @param $mobile
     * @param array $parameters
     * @param null $method
     * @param null $module
     * @param null $path
     */
    public function __construct($signName, $templateCode, $mobile, $parameters = null, $method = null, $module = null, $path = null)
    {
        $this->set('signName', $signName);
        $this->set('templateCode', $templateCode);
        $this->set('mobile', $mobile);
        $this->set('params', $parameters);
        $this->method = $method;
        $this->module = $module;
        $this->path = $path;

        parent::__construct();
    }

    /**
     * @return bool
     * @throws ParameterValueErrorException
     * @throws RequiredParameterLackException
     */
    public function check()
    {
        $requiredParametersLack = [];
        $parameterValueError = [];

        !$this->signName && $requiredParametersLack[] = 'signName';
        !$this->templateCode && $requiredParametersLack[] = 'templateCode';
        !$this->mobile && $requiredParametersLack[] = 'mobile';
        !$this->method && $requiredParametersLack[] = 'method';

        if ($requiredParametersLack) {
            throw new RequiredParameterLackException($requiredParametersLack);
        }

        !preg_match('/^1[3-9]{1}\d{9}$/', $this->mobile) && $parameterValueError[] = 'mobile';

        if ($parameterValueError) {
            throw new ParameterValueErrorException($parameterValueError);
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getSignName()
    {
        return $this->signName;
    }

    /**
     * @param mixed $signName
     */
    public function setSignName($signName)
    {
        $this->signName = $signName;
    }

    /**
     * @return mixed
     */
    public function getTemplateCode()
    {
        return $this->templateCode;
    }

    /**
     * @param mixed $templateCode
     */
    public function setTemplateCode($templateCode)
    {
        $this->templateCode = $templateCode;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
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

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }
}