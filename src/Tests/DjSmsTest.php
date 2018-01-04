<?php

namespace DavinBao\DjSms\Tests;

use DavinBao\DjSms\DjSms;
use DavinBao\DjSms\ParameterBags\ResponseParameterBag;

class DjSmsTest extends \PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $djSms = new DjSms();

        // If request is successful, 'data' member parameter will show the request_id; If fails, an exception will occur in
        $this->assertTrue($djSms->send('SignName', 'TemplateCode', 'MobileNumber', []) instanceof ResponseParameterBag);
    }

    public function testQuery()
    {
        $djSms = new DjSms();

        // Result is in the 'data' member parameter
        $this->assertTrue($djSms->query('RequestId') instanceof ResponseParameterBag);
    }

    public function testGetTemplate()
    {
        $djSms = new DjSms();

        // If the template is existed, the template info will show in the 'data' member parameter
        $this->assertTrue($djSms->getTemplate('TemplateCode') instanceof ResponseParameterBag);
    }

    public function testGetTemplates()
    {
        $djSms = new DjSms();

        // 'data' member parameter will show your all templates, 'count' member parameter will show you the count of
        // your parameters; All the request parameters is non-essential
        $this->assertTrue($djSms->getTemplateList('SearchContent', 'SmsType', 'GetPublic', 'Limit', 'Offset') instanceof ResponseParameterBag);
    }
}