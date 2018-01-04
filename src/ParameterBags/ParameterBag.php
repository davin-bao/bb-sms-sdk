<?php

namespace DavinBao\DjSms\ParameterBags;

/**
 * Class ParameterBag
 * @package DavinBao\DjSms\ParameterBags
 */
abstract class ParameterBag
{
    /**
     * @var array
     */
    protected $parameterList = [];

    /**
     * ParameterBag constructor.
     */
    public function __construct()
    {
        $this->check();
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function get($key, $default = null)
    {

        if (isset($this->$key)) {
            return $this->$key;
        }

        return $default;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->parameterList[$key] = $value;
        $this->$key = $value;
    }

    /**
     * @return array
     */
    public function getParameterList()
    {
        return $this->parameterList;
    }

    /**
     * @return array
     */
    public function getHttpParameterList()
    {
        $httpParameterList = [];

        foreach ($this->parameterList as $parameterName => $value) {
            ($value !== null && $value !== '') && $httpParameterList[self::toSnake($parameterName)] = trim($value);
        }

        return $httpParameterList;
    }

    /**
     * @param $camel
     * @return mixed|string
     */
    public static function toSnake($camel)
    {
        $value = preg_replace('/\s+/u', '', $camel);

        return mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . '_', $value));
    }

    /**
     * @return mixed
     */
    protected abstract function check();
}