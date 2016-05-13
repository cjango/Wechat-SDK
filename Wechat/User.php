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
 * 用户管理
 */
class User extends Wechat
{

    /**
     * 接口名称与URL映射
     * @var array
     */
    protected static $url = [
        'user_get'        => 'https://api.weixin.qq.com/cgi-bin/user/get',
        'user_info'       => 'https://api.weixin.qq.com/cgi-bin/user/info',
        'user_info_batch' => 'https://api.weixin.qq.com/cgi-bin/user/info/batchget',
        'user_remark'     => 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark',
        'user_in_group'   => 'https://api.weixin.qq.com/cgi-bin/groups/getid',
        'user_to_group'   => 'https://api.weixin.qq.com/cgi-bin/groups/members/update',
        'batch_to_group'  => 'https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate',
    ];

    /**
     * 获取全部关注用户
     * @param  [type] $nextOpenid [description]
     */
    public static function get($nextOpenid = '')
    {
        $params = [
            'next_openid'  => $nextOpenid,
            'access_token' => parent::$config['access_token'],
        ];
        $result = Utils::api(self::$url['user_get'], $params);
        if ($result) {
            return $result['data']['openid'];
        } else {
            return false;
        }
    }

    /**
     * 获取用户信息
     * @param  [type] $openid [description]
     * @param  [type] $lang   [description]
     * @return [type]         [description]
     */
    public static function info($openid, $lang = 'zh_CN')
    {
        $params = [
            'openid'       => $openid,
            'access_token' => parent::$config['access_token'],
            'lang'         => $lang,
        ];
        $result = Utils::api(self::$url['user_info'], $params);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 设置用户备注名
     * @param  [type] $openid
     * @param  [type] $remark
     * @return [type]
     */
    public static function remark($openid, $remark)
    {
        $params = [
            'openid' => $openid,
            'remark' => $remark,
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        return Utils::api(self::$url['user_remark'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    /**
     * 查询用户所在分组
     * @param  [type] $openid [description]
     * @return [type]         [description]
     */
    public static function getgroup($openid)
    {
        $params = [
            'openid' => $openid,
        ];
        $params = json_encode($params);
        $result = Utils::api(self::$url['user_in_group'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
        if ($result) {
            return $result['groupid'];
        } else {
            return false;
        }
    }

    /**
     * 移动用户分组
     */
    public static function togroup($openid, $groupid)
    {
        $params = [
            'openid'     => $openid,
            'to_groupid' => $groupid,
        ];
        $params = json_encode($params);
        return Utils::api(self::$url['user_to_group'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    /**
     * 批量移动用户分组
     * @param  array  $openid_list [description]
     * @param  [type] $groupid     [description]
     * @return [type]              [description]
     */
    public static function batchgroup($openid_list = [], $groupid)
    {
        $params = [
            'openid_list' => $openid_list,
            'to_groupid'  => $groupid,
        ];
        $params = json_encode($params);
        return Utils::api(self::$url['batch_to_group'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }
}
