<?php

namespace DavinBao\DjSms\Exceptions;

/**
 * Class RequiredParameterLackException
 * @package DavinBao\DjSms\Exceptions
 */
class RequiredParameterLackException extends SmsException
{
    /**
     * RequiredParameterLackException constructor.
     * @param null $requiredParameters
     * @param null $message
     * @param null $code
     * @param \Exception|null $previous
     */
    public function __construct($requiredParameters, $message = null, $code = null, \Exception $previous = null)
    {
        $requiredParameters = is_array($requiredParameters) ? implode(',', $requiredParameters) : $requiredParameters;

        $message = $message ? $message : 'Lack the required parameter [ ' . $requiredParameters . ' ]';

        parent::__construct($message, $code, $previous);
    }
}