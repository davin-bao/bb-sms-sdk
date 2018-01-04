<?php

namespace DavinBao\DjSms\Exceptions;

/**
 * Class ParameterValueErrorException
 * @package DavinBao\DjSms\Exceptions
 */
class ParameterValueErrorException extends SmsException
{
    /**
     * ParameterValueErrorException constructor.
     * @param null $errorParameters
     * @param null $message
     * @param null $code
     * @param \Exception|null $previous
     */
    public function __construct($errorParameters, $message = null, $code = null, \Exception $previous = null)
    {
        $errorParameters = is_array($errorParameters) ? implode(',', $errorParameters) : $errorParameters;

        $message = $message ? $message : 'Parameter value error [ ' . $errorParameters . ' ]';

        parent::__construct($message, $code, $previous);
    }
}