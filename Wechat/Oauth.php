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
 * ACCESS TOKEN获取
 */
class Oauth extends Wechat
{

    /**
     * 接口名称与URL映射
     * @var array
     */
    protected static $url = [
        'oauth_authorize'    => 'https://open.weixin.qq.com/connect/oauth2/authorize',
        'oauth_user_token'   => 'https://api.weixin.qq.com/sns/oauth2/access_token',
        'oauth_get_userinfo' => 'https://api.weixin.qq.com/sns/userinfo',
    ];

    /**
     * OAuth 用户同意授权，获取code
     * @param  [type] $callback 回调URI，填写完整地址，带http://
     * @param  string $state    重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值
     * @param  string $scope    snsapi_userinfo 获取用户授权信息，snsapi_base直接返回openid
     * @return string
     */
    public static function url($callback, $state = 'STATE', $scope = 'snsapi_base')
    {
        $params = [
            'appid'         => self::$config['appid'],
            'redirect_uri'  => $callback,
            'response_type' => 'code',
            'scope'         => $scope,
            'state'         => $state,
        ];
        return self::$url['oauth_authorize'] . '?' . http_build_query($params) . '#wechat_redirect';
    }

    /**
     * 通过code获取Access Token
     * @return array|boolean
     */
    public static function token()
    {
        $code = isset($_GET['code']) ? $_GET['code'] : '';
        if (!$code) {
            parent::$error = '未获取到CODE信息';
            return false;
        }
        $params = [
            'appid'      => self::$config['appid'],
            'secret'     => self::$config['secret'],
            'code'       => $code,
            'grant_type' => 'authorization_code',
        ];
        return Utils::api(self::$url['oauth_user_token'], $params);
    }

    /**
     * 网页获取用户信息
     * @param  string $access_token  通过getOauthAccessToken方法获取到的token
     * @param  string $openid        用户的OPENID
     * @return array
     */
    public static function info($token, $openid)
    {
        $params = [
            'access_token' => $token,
            'openid'       => $openid,
            'lang'         => 'zh_CN',
        ];
        return Utils::api(self::$url['oauth_get_userinfo'], $params);
    }
}
