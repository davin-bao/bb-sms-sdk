<?php

namespace DavinBao\DjSms\Http;

use DavinBao\DjSms\ParameterBags\ParameterBag;

/**
 * Interface HttpInterface
 * @package DavinBao\DjSms\Http
 */
interface HttpInterface
{
    /**
     * HttpInterface constructor.
     * @param ParameterBag $parameterBag
     */
    function __construct(ParameterBag $parameterBag);
}