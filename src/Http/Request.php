<?php

namespace DavinBao\DjSms\Http;

use DavinBao\DjSms\Exceptions\RequiredParameterLackException;
use DavinBao\DjSms\Exceptions\SmsException;
use DavinBao\DjSms\ParameterBags\ApiAuthorityParameterBag;
use DavinBao\DjSms\ParameterBags\ParameterBag;
use DavinBao\DjSms\ParameterBags\ResponseParameterBag;

/**
 * Class Request
 * @package DavinBao\DjSms\Http
 */
class Request implements HttpInterface
{
    /**
     * @var string
     */
    private $host = 'sms.bibi.com.cn/';
    /**
     * @var string
     */
    private $path = 'api/';
    /**
     * @var string
     */
    private $version = 'v1';
    /**
     * @var string
     */
    private $secret = "\x00\x00\x00\x00\x00\x00\x00\x00\x00";

    /**
     * @var
     */
    private $curlHandle;
    /**
     * @var
     */
    private $method;
    /**
     * @var int
     */
    private $timeout = 180;

    /**
     * @var ApiAuthorityParameterBag|ParameterBag
     */
    private $apiAuthorityParameterBag;
    /**
     * @var ParameterBag
     */
    private $parameterBag;

    /**
     *
     */
    const HTTP_GET = 'GET';
    /**
     *
     */
    const HTTP_POST = 'POST';
    /**
     *
     */
    const HTTP_PUT = 'PUT';
    /**
     *
     */
    const HTTP_DELETE = 'DELETE';

    /**
     * Request constructor.
     * @param ParameterBag $apiAuthorityParameterBag
     * @param ParameterBag|null $parameterBag
     */
    public function __construct(ParameterBag $apiAuthorityParameterBag, ParameterBag $parameterBag = null)
    {
        if (!$apiAuthorityParameterBag instanceof ApiAuthorityParameterBag) {
            throw new RequiredParameterLackException('ApiAuthorityParameterBag');
        }

        $this->apiAuthorityParameterBag = $apiAuthorityParameterBag;
        $this->parameterBag = $parameterBag;
    }

    /**
     * @return resource
     */
    public function prepare()
    {
        $method = $this->parameterBag->get('method', 'post');
        $module = $this->parameterBag->get('module');
        $path = $this->parameterBag->get('path');
        $path = $path ? $path : $module;
        $parameters = $this->parameterBag->getHttpParameterList();

        $this->curlHandle = $curlHandle = curl_init();
        $curlHandle = $this->setMethod($curlHandle, $method, $parameters);

        curl_setopt($curlHandle, CURLOPT_URL, $this->getRequestUrl($path, $parameters));
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_HEADER, false);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $this->getHeaders());

        return $curlHandle;
    }

    /**
     * @return Response
     * @throws SmsException
     */
    public function send()
    {
        if (!is_resource($this->curlHandle)) {
            throw new SmsException('Please prepare the request');
        }

        $curlHandle = $this->curlHandle;
        $response = curl_exec($curlHandle);
        $responseInfo = curl_getinfo($curlHandle);
        curl_close($curlHandle);

        $responseParameterBag = new ResponseParameterBag($response, $responseInfo['url'], $responseInfo['http_code'], $responseInfo['header_size'],
            $responseInfo['request_size'], $responseInfo['total_time'], $responseInfo['local_ip'], $responseInfo['local_port']);

        return new Response($responseParameterBag);
    }

    /**
     * @param $curlHandle
     * @param $method
     * @param $parameters
     * @return mixed
     */
    private function setMethod($curlHandle, $method, &$parameters)
    {
        switch (strtoupper($method)) {
            case self::HTTP_POST :
                $this->method = self::HTTP_POST;

                curl_setopt($curlHandle, CURLOPT_POST, true);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $parameters);
                $parameters = [];

                break;

            case self::HTTP_PUT :
                $this->method = self::HTTP_PUT;

                curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, self::HTTP_PUT);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $parameters);
                $parameters = [];

                break;
            case self::HTTP_DELETE :
                $this->method = self::HTTP_DELETE;

                curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, self::HTTP_DELETE);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $parameters);
                $parameters = [];

                break;

            default :
                $this->method = self::HTTP_GET;
        }

        return $curlHandle;
    }

    /**
     * @param null $path
     * @param null $parameters
     * @return string
     */
    private function getRequestUrl($path = null, $parameters = null)
    {
        return $this->host
        . $this->path
        . $this->version . '/'
        . $path
        . ($parameters ? '?' . http_build_query($parameters) : null);
    }

    /**
     * @return array
     */
    private function getHeaders()
    {
        return [
            'api-key: ' . $this->apiAuthorityParameterBag->getApiKey(),
            'timestamp: ' . $this->apiAuthorityParameterBag->getTimestamp(),
            'signature: ' . $this->getSignature()
        ];
    }

    /**
     * @return string
     */
    private function getSignature()
    {
        return md5($this->apiAuthorityParameterBag->getApiKey()
            . $this->secret
            . $this->apiAuthorityParameterBag->getSecretKey()
            . $this->apiAuthorityParameterBag->getTimestamp());
    }
}