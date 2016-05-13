## 微信SDK静态版

使用方式

$config = [
    'appid'  => '',
    'secret' => '',
];
\tools\Wechat::init($config);
$token = \tools\WechatToken::get();
