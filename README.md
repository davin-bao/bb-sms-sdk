# SMS SDK

点击网络短信 SDK

```php
use DavinBao\DjSms\DjSms;

$smsClient = new DjSms($apiKey = null, $secretKey = null, $timestamp = null);

$smsClient->send($signName, $templateCode, $mobile, array $parameters = []); // 发送短信
$smsClient->query($requestId); // 查询短信发送结果
$smsClient->getTemplate($code); // 获取模板信息
$smsClient->getTemplateList($searchContent = null, $smsType = null, $getPublic = null, $limit = null, $offset = null); // 获取模板列表
```

## 安装

### 使用 Composer
在您的 composer.json 中添加

```json
{
    "require": {
        "davin-bao/bb-sms-sdk": "dev-master"
    }
}
```
使用 composer 安装依赖

```
$ composer require davin-bao/bb-sms-sdk
```
导入自动加载文件

```php
<?php
require  __DIR__ . '/vendor/autoload.php';

use DavinBao\DjSms\DjSms;

$smsClient = new DjSms($apiKey = null, $secretKey = null, $timestamp = null);
```

### 不使用 Composer
直接导入自动加载文件即可
```php
<?php
require __DIR__ . '/davin-bao/vendor/autoload.php';

use DavinBao\DjSms\DjSms;

$smsClient = new DjSms($apiKey = null, $secretKey = null, $timestamp = null);
```