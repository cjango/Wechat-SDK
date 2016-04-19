<?php
// +------------------------------------------------+
// |http://www.cjango.com                           |
// +------------------------------------------------+
// | 修复BUG不是一朝一夕的事情，等我喝醉了再说吧！  |
// +------------------------------------------------+
// | Author: 小陈叔叔 <Jason.Chen>                  |
// +------------------------------------------------+
namespace tools\Wechat;

use tools\Wechat;

/**
 * 微信支付相关部分
 */
class Pay extends Wechat
{
    /**
     * 接口名称与URL映射
     * @var array
     */
    protected static $url = [
        'unified_order'       => 'https://api.mch.weixin.qq.com/pay/unifiedorder', // 统一下单地址
        'order_query'         => 'https://api.mch.weixin.qq.com/pay/orderquery', // 订单状态查询
        'close_order'         => 'https://api.mch.weixin.qq.com/pay/closeorder', // 关闭订单
        'pay_refund_order'    => 'https://api.mch.weixin.qq.com/secapi/pay/refund', // 退款地址
        'refund_query'        => 'https://api.mch.weixin.qq.com/pay/refundquery', // 退款查询
        'pay_transfers'       => 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers', // 企业付款
        'get_pay_transfers'   => 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gettransferinfo', // 企业付款查询
        'download_bill'       => 'https://api.mch.weixin.qq.com/pay/downloadbill', // 下载对账单
        'send_red_pack'       => 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack', // 发放红包高级接口
        'send_group_red_pack' => 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack', // 发送裂变红包接口(拼手气)
        'get_red_pack_info'   => 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo', // 红包查询接口
    ];

    /**
     * 返回随机填充的字符串
     */
    protected static function getRandomStr($lenght = 16)
    {
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $strPol = str_repeat($str_pol, 3);
        return substr(str_shuffle($str_pol), 0, $lenght);
    }

    /**
     * 统一下单支付
     * @param  string $orderId    系统订单号
     * @param  string $body       产品描述
     * @param  string $money      支付金额
     * @param  string $trade_type (JSAPI NATIVE APP)
     * @param  string $notify_url 回调URL
     * @param  string $openid     支付用户
     * @param  string $attach     附加信息
     * @return array
     */
    public static function unifiedOrder($orderId, $body, $money, $tradeType, $notifyUrl = '', $openid = '', $attach = '')
    {
        $params = [
            'appid'            => parent::$config['appid'],
            'mch_id'           => parent::$config['mch_id'],
            'nonce_str'        => self::_getRandomStr(),
            'body'             => $body,
            'out_trade_no'     => $orderId,
            'total_fee'        => $money * 100, // 转换成分
            'spbill_create_ip' => self::_getClientIp(),
            'notify_url'       => $notifyUrl,
            'trade_type'       => $tradeType,
        ];
        if (!empty($openid) && $notifyUrl == 'JSAPI') {
            $params['openid'] = $openid;
        }
        if (!empty($attach)) {
            $params['attach'] = $attach;
        }
        $params['sign'] = self::_getOrderSign($params);
        $data           = Utils::array2xml($params);
        $data           = Utils::http(self::$url['unified_order'], $data, 'POST');
        return self::parsePayResult(Utils::xml2array($data));
    }

    /**
     * 查询订单
     * @param  [type] $out_trade_no [description]
     * @return [type]               [description]
     */
    public static function orderQuery($orderId = '', $type = 'out_trade_no')
    {
        $params = [
            'appid'     => parent::$config['appid'],
            'mch_id'    => parent::$config['mch_id'],
            'nonce_str' => self::_getRandomStr(),
        ];
        if ($type == 'out_trade_no') {
            $params['out_trade_no'] = $orderId;
        } else {
            $params['transaction_id'] = $orderId;
        }
        $params['sign'] = self::_getOrderSign($params);
        $data           = Utils::array2xml($params);
        $data           = Utils::http(self::$url['order_query'], $data, 'POST');
        return Utils::xml2array($data);
    }

    /**
     * 解析支付接口的返回结果
     * @param  xmlstring $data      接口返回的数据
     * @param  boolean   $checkSign 是否需要签名校验
     * @return boolean|array
     */
    public static function parsePayRequest($checkSign = true)
    {
        $data = parent::request();
        if (empty($data)) {
            parent::$error = '回调结果解析失败';
            return false;
        }
        if ($checkSign) {
            $sign = $data['sign'];
            unset($data['sign']);
            if (self::_getOrderSign($data) != $sign) {
                parent::$error = '签名校验失败';
                return false;
            }
        }
        return self::parsePayResult($data);
    }

    /**
     * 解析支付借口的返回数据
     * @param  [type] $data [description]
     */
    private static function parsePayResult($data)
    {
        if ($data['return_code'] == 'SUCCESS') {
            if ($data['result_code'] == 'SUCCESS') {
                return $data;
            } else {
                parent::$error = $data['err_code'];
                return false;
            }
        } else {
            parent::$error = $data['return_msg'];
            return false;
        }
    }

    /**
     * 支付结果通知
     * @param  [type] $code 支付结果
     * @param  [type] $msg  返回信息
     * @return xml
     */
    public static function returnNotify($msg = true)
    {
        if ($msg === true) {
            $params = [
                'return_code' => 'SUCCESS',
                'return_msg'  => '',
            ];
        } else {
            $params = [
                'return_code' => 'FAIL',
                'return_msg'  => $msg,
            ];
        }
        exit(Utils::array2xml($params));
    }

    /**
     * 获取客户端IP地址
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    private static function _getClientIp($type = 0, $adv = true)
    {
        $type      = $type ? 1 : 0;
        static $ip = null;
        if ($ip !== null) {
            return $ip[$type];
        }

        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) {
                    unset($arr[$pos]);
                }

                $ip = trim($arr[0]);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip   = $long ? [$ip, $long] : ['0.0.0.0', 0];
        return $ip[$type];
    }

    /**
     * 本地MD5签名
     * @param  array $params 需要签名的数据
     * @return string        大写字母与数字签名（串32位）
     */
    private static function _getOrderSign($params)
    {
        ksort($params);
        $params['key'] = parent::$config['paykey'];
        return strtoupper(md5(urldecode(http_build_query($params))));
    }

    /**
     * 返回随机填充的字符串
     * @param  integer $length 长度
     * @return string(16)
     */
    private static function _getRandomStr($lenght = 16)
    {
        $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        return substr(str_shuffle($str_pol), 0, $lenght);
    }
}
