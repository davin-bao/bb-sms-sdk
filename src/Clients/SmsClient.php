<?php

namespace DavinBao\DjSms\Clients;

use DavinBao\DjSms\Exceptions\RequestErrorException;
use DavinBao\DjSms\Exceptions\RequiredParameterLackException;
use DavinBao\DjSms\Http\Request;
use DavinBao\DjSms\ParameterBags\ApiAuthorityParameterBag;
use DavinBao\DjSms\ParameterBags\ParameterBag;
use DavinBao\DjSms\ParameterBags\QueryParameterBag;
use DavinBao\DjSms\ParameterBags\SendingParameterBag;
use DavinBao\DjSms\ParameterBags\TemplateParameterBag;
use DavinBao\DjSms\ParameterBags\TemplatesParameterBag;

/**
 * Class SmsClient
 * @package DavinBao\DjSms\Clients
 */
class SmsClient
{
    /**
     * @var ApiAuthorityParameterBag
     */
    private $apiAuthorityParameterBag;
    /**
     * @var
     */
    private $parameterBag;

    /**
     * SmsClient constructor.
     * @param $apiKey
     * @param $secretKey
     * @param $timestamp
     */
    public function __construct($apiKey, $secretKey, $timestamp)
    {
        $this->apiAuthorityParameterBag = new ApiAuthorityParameterBag($apiKey, $secretKey, $timestamp);
    }

    /**
     * @param $signName
     * @param $templateCode
     * @param $mobile
     * @param array $parameters
     * @return mixed
     * @throws RequiredParameterLackException
     * @throws \DjSms\Exceptions\SmsException
     */
    public function send($signName, $templateCode, $mobile, array $parameters)
    {
        $method = Request::HTTP_POST;
        $module = 'message';
        $parameters = $parameters ? json_encode($parameters) : null;

        $this->parameterBag = new SendingParameterBag($signName, $templateCode, $mobile, $parameters, $method, $module);
        $this->parameterBag->set('request_id', $this->getRequestId());

        return $this->request();
    }

    /**
     * @param $requestId
     * @return ParameterBag|\DjSms\ParameterBags\ResponseParameterBag
     * @throws RequestErrorException
     */
    public function query($requestId)
    {
        $method = Request::HTTP_GET;
        $module = 'message';

        $this->parameterBag = new QueryParameterBag($requestId, $method, $module);

        $response = $this->request();

        if (!$response->getData()) {
            throw new RequestErrorException;
        }

        return $response;
    }

    /**
     * @param $code
     * @return ParameterBag|\DjSms\ParameterBags\ResponseParameterBag
     * @throws RequiredParameterLackException
     */
    public function getTemplate($code)
    {
        $method = Request::HTTP_GET;
        $module = 'template';

        $this->parameterBag = new TemplateParameterBag($code, $method, $module);
        $this->parameterBag->set('request_id', $this->getRequestId());

        return $this->request();
    }

    /**
     * @param null $searchContent
     * @param null $smsType
     * @param null $getPublic
     * @param null $limit
     * @param null $offset
     * @return ParameterBag|\DjSms\ParameterBags\ResponseParameterBag
     * @throws RequiredParameterLackException
     */
    public function getTemplateList($searchContent = null, $smsType = null, $getPublic = null, $limit = null, $offset = null)
    {
        $method = Request::HTTP_GET;
        $module = 'templates';

        $this->parameterBag = new TemplatesParameterBag($searchContent, $smsType, $getPublic, $limit, $offset, $method, $module);
        $this->parameterBag->set('request_id', $this->getRequestId());

        return $this->request();
    }

    /**
     * @return ParameterBag|\DjSms\ParameterBags\ResponseParameterBag
     * @throws RequestErrorException
     * @throws \DjSms\Exceptions\AuthorityErrorException
     * @throws \DjSms\Exceptions\ParameterValueErrorException
     * @throws \DjSms\Exceptions\SmsException
     */
    private function request()
    {
        $request = new Request($this->apiAuthorityParameterBag, $this->parameterBag);
        $request->prepare();
        $response = $request->send();

        return $response->parse();
    }

    /**
     * @return string
     * @throws RequiredParameterLackException
     */
    public function getRequestId()
    {
        if (!$this->parameterBag instanceof ParameterBag) {
            throw new RequiredParameterLackException('parameterBag');
        }

        return sha1($this->apiAuthorityParameterBag->getTimestamp()
            . $this->apiAuthorityParameterBag->getApiKey()
            . $this->parameterBag->get('signName')
            . $this->parameterBag->get('templateCode')
            . $this->parameterBag->get('params')
            . $this->parameterBag->get('mobile'));
    }

    /**
     * @return ApiAuthorityParameterBag
     */
    public function getApiAuthorityParameterBag()
    {
        return $this->apiAuthorityParameterBag;
    }

    /**
     * @param ApiAuthorityParameterBag $apiAuthorityParameterBag
     */
    public function setApiAuthorityParameterBag($apiAuthorityParameterBag)
    {
        $this->apiAuthorityParameterBag = $apiAuthorityParameterBag;
    }

    /**
     * @return mixed
     */
    public function getParameterBag()
    {
        return $this->parameterBag;
    }

    /**
     * @param mixed $parameterBag
     */
    public function setParameterBag($parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }
}