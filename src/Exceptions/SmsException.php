<?php

namespace DavinBao\DjSms\Exceptions;

/**
 * Class SmsException
 * @package DavinBao\DjSms\Exceptions
 */
class SmsException extends \Exception
{
    /**
     * SmsException constructor.
     * @param null $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = null, $code = 500, \Exception $previous = null)
    {
        $message = $message ? $message : 'Request failed';

        parent::__construct($message, $code, $previous);
    }
}