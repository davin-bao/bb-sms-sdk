<?php

namespace DavinBao\DjSms;

use DavinBao\DjSms\Clients\SmsClient;

/**
 * Class DjSms
 * @package DjSms
 */
class DjSms
{
    /**
     * @var DjSms
     */
    private static $instance;
    /**
     * @var
     */
    private static $hasInstance = false;
    /**
     * @var
     */
    private static $client;
    /**
     * Please input your api key here
     * @var
     */
    private $apiKey = '';
    /**
     * Please input your secret key here
     * @var
     */
    private $secretKey = '';
    /**
     * @var
     */
    private $timestamp;

    /**
     * DjSms constructor.
     * @param $apiKey
     * @param $secretKey
     * @param null $timestamp
     */
    public function __construct($apiKey = null, $secretKey = null, $timestamp = null)
    {
        if (self::$hasInstance) {
            return self::$instance;
        }

        $apiKey && $this->apiKey = $apiKey;
        $secretKey && $this->secretKey = $secretKey;
        $this->timestamp = $timestamp ? $timestamp : (new \DateTime('now'))->setTimezone(new \DateTimeZone('PRC'))->format('mdHis');
        self::$hasInstance = true;

        return self::$instance = new DjSms($apiKey, $secretKey, $timestamp);
    }

    /**
     * @return SmsClient
     */
    public function getClient()
    {
        if (self::$client instanceof SmsClient) {
            return self::$client;
        }

        return self::$client = new SmsClient($this->apiKey, $this->secretKey, $this->timestamp);
    }

    /**
     * @param SmsClient $smsClient
     */
    public function setClient(SmsClient $smsClient)
    {
        self::$client = $smsClient;
    }

    /**
     * @param $signName
     * @param $templateCode
     * @param $mobile
     * @param array $parameters
     * @return mixed
     */
    public function send($signName, $templateCode, $mobile, array $parameters = [])
    {
        return $this->getClient()->send($signName, $templateCode, $mobile, $parameters);
    }

    /**
     * @param $requestId
     * @return ParameterBags\ParameterBag|ParameterBags\ResponseParameterBag
     * @throws Exceptions\RequestErrorException
     */
    public function query($requestId)
    {
        return $this->getClient()->query($requestId);
    }

    /**
     * @param $code
     * @return ParameterBags\ParameterBag|ParameterBags\ResponseParameterBag
     */
    public function getTemplate($code)
    {
        return $this->getClient()->getTemplate($code);
    }

    /**
     * @param null $searchContent
     * @param null $smsType
     * @param null $getPublic
     * @param null $limit
     * @param null $offset
     * @return ParameterBags\ParameterBag|ParameterBags\ResponseParameterBag
     */
    public function getTemplateList($searchContent = null, $smsType = null, $getPublic = null, $limit = null, $offset = null)
    {
        return $this->getClient()->getTemplateList($searchContent, $smsType, $getPublic, $limit, $offset);
    }
}