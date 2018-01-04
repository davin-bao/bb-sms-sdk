<?php

namespace DavinBao\DjSms\Exceptions;

/**
 * Class AuthorityErrorException
 * @package DavinBao\DjSms\Exceptions
 */
class AuthorityErrorException extends SmsException
{
    /**
     * AuthorityErrorException constructor.
     * @param null $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = null, $code = 500, \Exception $previous = null)
    {
        $message = $message ? $message : 'Authority error';

        parent::__construct($message, $code, $previous);
    }
}