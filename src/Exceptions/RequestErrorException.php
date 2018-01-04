<?php

namespace DavinBao\DjSms\Exceptions;

/**
 * Class RequestErrorException
 * @package DavinBao\DjSms\Exceptions
 */
class RequestErrorException extends SmsException
{
    /**
     * RequestErrorException constructor.
     * @param null $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = null, $code = 500, \Exception $previous = null)
    {
        $message = $message ? $message : 'Request successfully,but the response maybe not as you wish';

        parent::__construct($message, $code, $previous);
    }
}