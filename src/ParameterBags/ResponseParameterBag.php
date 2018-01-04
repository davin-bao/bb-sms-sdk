<?php

namespace DavinBao\DjSms\ParameterBags;
use DavinBao\DjSms\Exceptions\SmsException;

/**
 * Class ResponseParameterBag
 * @package DavinBao\DjSms\ParameterBags
 */
class ResponseParameterBag extends ParameterBag
{
    /**
     * @var
     */
    protected $rawResponse;
    /**
     * @var
     */
    protected $data;
    /**
     * @var
     */
    protected $status;
    /**
     * @var
     */
    protected $message;
    /**
     * @var null
     */
    protected $url;
    /**
     * @var null
     */
    protected $httpCode;
    /**
     * @var null
     */
    protected $headerSize;
    /**
     * @var
     */
    protected $requestSize;
    /**
     * @var null
     */
    protected $requestTime;
    /**
     * @var null
     */
    protected $localIp;
    /**
     * @var null
     */
    protected $localPort;

    /**
     * ResponseParameterBag constructor.
     * @param $response
     * @param null $url
     * @param null $httpCode
     * @param null $headerSize
     * @param null $requestSize
     * @param null $requestTime
     * @param null $localIp
     * @param null $localPort
     */
    public function __construct($response, $url = null, $httpCode = null, $headerSize = null, $requestSize = null,
                                $requestTime = null, $localIp = null, $localPort = null)
    {
        $this->rawResponse = $response;
        $this->url = $url;
        $this->httpCode = $httpCode;
        $this->headerSize = $headerSize;
        $this->requestSize = $response;
        $this->requestTime = $requestTime;
        $this->localIp = $localIp;
        $this->localPort = $localPort;

        parent::__construct();
    }

    /**
     * @throws SmsException
     */
    public function check()
    {
        if (!$this->rawResponse) {
            throw new SmsException;
        }
    }

    /**
     * @return mixed
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * @return null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return null
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @return null
     */
    public function getHeaderSize()
    {
        return $this->headerSize;
    }

    /**
     * @return mixed
     */
    public function getRequestSize()
    {
        return $this->requestSize;
    }

    /**
     * @return null
     */
    public function getRequestTime()
    {
        return $this->requestTime;
    }

    /**
     * @return null
     */
    public function getLocalIp()
    {
        return $this->localIp;
    }

    /**
     * @return null
     */
    public function getLocalPort()
    {
        return $this->localPort;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        if ($this->data === null) {
            $this->data = $data;
        }
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        if ($this->status === null) {
            $this->status = $status;
        }
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        if ($this->message === null) {
            $this->message = $message;
        }
    }
}