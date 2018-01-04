<?php

namespace DavinBao\DjSms\ParameterBags;

use DavinBao\DjSms\Exceptions\ParameterValueErrorException;
use DavinBao\DjSms\Exceptions\RequiredParameterLackException;

/**
 * Class TemplatesParameterBag
 * @package DavinBao\DjSms\ParameterBags
 */
class TemplatesParameterBag extends ParameterBag
{
    /**
     * @var
     */
    protected $searchContent;
    /**
     * @var null
     */
    protected $smsType;
    /**
     * @var null
     */
    protected $getPublic;
    /**
     * @var
     */
    protected $limit;
    /**
     * @var
     */
    protected $offset;
    /**
     * @var null
     */
    protected $method;
    /**
     * @var null
     */
    protected $module;

    /**
     * TemplatesParameterBag constructor.
     * @param null $searchContent
     * @param null $smsType
     * @param null $getPublic
     * @param null $limit
     * @param null $offset
     * @param null $method
     * @param null $module
     */
    public function __construct($searchContent = null, $smsType = null, $getPublic = null, $limit = null,
                                $offset = null, $method = null, $module = null)
    {
        $this->set('searchContent', $searchContent);
        $this->set('smsType', $smsType);
        $this->set('getPublic', $getPublic);
        $this->set('limit', $limit);
        $this->set('offset', $offset);
        $this->method = $method;
        $this->module = $module;

        parent::__construct();
    }

    /**
     * @throws RequiredParameterLackException
     */
    public function check()
    {
        $parameterValueError = [];

        $this->limit && !is_int($this->limit) && $parameterValueError[] = 'limit';
        $this->offset && !is_int($this->offset) && $parameterValueError[] = 'offset';

        if ($parameterValueError) {
            throw new ParameterValueErrorException($parameterValueError);
        }
    }
}