<?php

namespace DavinBao\DjSms\ParameterBags;

use DavinBao\DjSms\Exceptions\RequiredParameterLackException;

/**
 * Class ApiAuthorityParameterBag
 * @package DavinBao\DjSms\ParameterBags
 */
class ApiAuthorityParameterBag extends ParameterBag
{
    /**
     * @var
     */
    protected $apiKey;
    /**
     * @var
     */
    protected $secretKey;
    /**
     * @var
     */
    protected $timestamp;

    /**
     * ApiAuthorityParameterBag constructor.
     * @param $apiKy
     * @param $secretKey
     * @param $timestamp
     */
    public function __construct($apiKy, $secretKey, $timestamp)
    {
        $this->set('apiKey', $apiKy);
        $this->set('secretKey', $secretKey);
        $this->set('timestamp', $timestamp);

        parent::__construct();
    }

    /**
     * @return bool
     * @throws RequiredParameterLackException
     */
    public function check()
    {
        $requiredParametersLack = [];

        !$this->apiKey && $requiredParametersLack[] = 'apiKey';
        !$this->secretKey && $requiredParametersLack[] = 'secretKey';
        !$this->timestamp && $requiredParametersLack[] = 'timestamp';

        if ($requiredParametersLack) {
            throw new RequiredParameterLackException($requiredParametersLack);
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param mixed $secretKey
     */
    public function setsecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }
}