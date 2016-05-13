<?php
// +------------------------------------------------+
// |http://www.cjango.com                           |
// +------------------------------------------------+
// | 修复BUG不是一朝一夕的事情，等我喝醉了再说吧！  |
// +------------------------------------------------+
// | Author: 小陈叔叔 <Jason.Chen>                  |
// +------------------------------------------------+
namespace tools;

/**
 * 微信公众平台开发SDK,
 * 架构问题又凌乱了.
 * @author 小陈叔叔 <20511924@qq.com>
 */
class Wechat
{
    /**
     * 保存错误信息
     * @var string
     */
    protected static $error = '';

    /**
     * 默认的配置参数
     * @var array
     */
    protected static $config = [
        'token'        => '',
        'appid'        => '',
        'secret'       => '',
        'access_token' => '',
        'encode'       => false,
        'AESKey'       => '',
        'mch_id'       => '',
        'paykey'       => '',
        'pem'          => '',
    ];

    /**
     * 传入初始化参数
     * 接受消息,如果是加密的需要传入一些参数,否则用不到
     */
    public function __construct($config = [])
    {
        if (!empty($config) && is_array($config)) {
            self::$config = array_merge(self::$config, $config);
        }
    }

    /**
     * 初始化
     * @param  array   $config
     * @param  boolean $force 强制初始化
     * @return [type]
     */
    public static function init($config = [], $force = false)
    {
        static $wechat;
        if (is_null($wechat) || $force == true) {
            $wechat = new Wechat($config);
        }
        return $wechat;
    }

    /**
     * 验证URL有效性,校验请求签名
     * @return string|boolean
     */
    public static function valid()
    {
        $echoStr = isset($_GET["echostr"]) ? $_GET["echostr"] : '';
        if ($echoStr) {
            self::checkSignature() && exit($echoStr);
        } else {
            !self::checkSignature() && exit('Access Denied!');
        }
        return true;
    }

    /**
     * 检查请求URL签名
     * @return boolean
     */
    private static function checkSignature()
    {
        $signature = isset($_GET['signature']) ? $_GET['signature'] : '';
        $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : '';
        $nonce     = isset($_GET['nonce']) ? $_GET['nonce'] : '';
        if (empty($signature) || empty($timestamp) || empty($nonce)) {
            return false;
        }
        $token  = self::$config['token'];
        $tmpArr = [$token, $timestamp, $nonce];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        return sha1($tmpStr) == $signature;
    }

    /**
     * 返回错误信息
     * @return string
     */
    public static function error($msg = null)
    {
        if (!is_null($msg)) {
            self::$error = $msg;
        } else {
            return self::$error;
        }
    }
}
