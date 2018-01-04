<?php

namespace DavinBao\DjSms\Http;

use DavinBao\DjSms\Exceptions\AuthorityErrorException;
use DavinBao\DjSms\Exceptions\ParameterValueErrorException;
use DavinBao\DjSms\Exceptions\RequestErrorException;
use DavinBao\DjSms\Exceptions\RequiredParameterLackException;
use DavinBao\DjSms\Exceptions\SmsException;
use DavinBao\DjSms\ParameterBags\ParameterBag;
use DavinBao\DjSms\ParameterBags\ResponseParameterBag;

/**
 * Class Response
 * @package DjSms\Http
 */
class Response implements HttpInterface
{
    /**
     * @var ParameterBag|ResponseParameterBag
     */
    private $responseParameterBag;

    /**
     * @var array
     */
    private static $authorityErrorCodes = [
        403,
        412
    ];

    /**
     * Response constructor.
     * @param ParameterBag $responseParameterBag
     * @throws RequiredParameterLackException
     */
    public function __construct(ParameterBag $responseParameterBag)
    {
        if (!$responseParameterBag instanceof ResponseParameterBag) {
            throw new RequiredParameterLackException('ResponseParameterBag');
        }

        $this->responseParameterBag = $responseParameterBag;
    }

    /**
     * @return ParameterBag|ResponseParameterBag
     * @throws AuthorityErrorException
     * @throws ParameterValueErrorException
     * @throws RequestErrorException
     * @throws SmsException
     */
    public function parse()
    {
        $rawResponse = $this->responseParameterBag->get('rawResponse');
        $failure = false;

        try {
            $response = json_decode($rawResponse);
        } catch (\Exception $e) {
            $failure = true;
        }

        if (empty($response) || $failure) {
            throw new SmsException;
        }

        $responseCode = !empty($response->statusCode) ? $response->statusCode : $this->responseParameterBag->getHttpCode();
        $responseMessage = !empty($response->message) ? $response->message : null;

        if ($responseCode != 200) {

            if ($responseCode == 422) {
                $parameterValueError = [];

                foreach ($response as $parameterName => $errorMessage) {
                    $parameterValueError[] = $parameterName;
                }
                throw new ParameterValueErrorException($parameterValueError);
            }

            if ($this->isAuthorityError($responseCode)) {
                throw new AuthorityErrorException;
            }

            throw new RequestErrorException($responseMessage);
        }

        $this->responseParameterBag->setData(empty($response->data) ? null : $response->data);
        $this->setOtherParameters($response);
        $this->responseParameterBag->setStatus($responseCode);
        $this->responseParameterBag->setMessage($responseMessage);

        return $this->responseParameterBag;
    }

    /**
     * @param $response
     */
    private function setOtherParameters($response)
    {
        foreach ($response as $parameterName => $value) {

            if (!in_array($parameterName, ['data', 'statusCode', 'message'])) {
                $this->responseParameterBag->$parameterName = $value;
            }
        }
    }

    /**
     * @param $responseCode
     * @return bool
     */
    private function isAuthorityError($responseCode)
    {
        return in_array($responseCode, self::$authorityErrorCodes) ? true : false;
    }
}