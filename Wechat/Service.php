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
 * 客服相关接口
 */
class Service extends Wechat
{
    /**
     * 接口名称与URL映射
     * @var array
     */
    protected static $url = [
        'service_list'   => 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist',
        'online_list'    => 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist',
        'service_add'    => 'https://api.weixin.qq.com/customservice/kfaccount/add',
        'service_update' => 'https://api.weixin.qq.com/customservice/kfaccount/update',
        'service_delete' => 'https://api.weixin.qq.com/customservice/kfaccount/del',
        'upload_avatr'   => 'Http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg',
        'msg_record'     => 'https://api.weixin.qq.com/customservice/msgrecord/getrecord',
        'custom_send'    => 'https://api.weixin.qq.com/cgi-bin/message/custom/send',
        'session_create' => 'https://api.weixin.qq.com/customservice/kfsession/create',
        'session_close'  => 'https://api.weixin.qq.com/customservice/kfsession/close',
        'session_get'    => 'https://api.weixin.qq.com/customservice/kfsession/getsession',
        'session_list'   => 'https://api.weixin.qq.com/customservice/kfsession/getsessionlist',
        'session_wait'   => 'https://api.weixin.qq.com/customservice/kfsession/getwaitcase',
    ];

    /**
     * 获取客服列表
     * @return [type] [description]
     */
    public static function get()
    {
        $result = Utils::api(self::$url['service_list'] . '?access_token=' . parent::$config['access_token']);
        if ($result) {
            return $result['kf_list'];
        } else {
            return false;
        }
    }

    /**
     * 获取在线客服
     * @return [type] [description]
     */
    public static function online()
    {
        return Utils::api(self::$url['online_list'] . '?access_token=' . parent::$config['access_token']);
        if ($result) {
            return $result['kf_online_list'];
        } else {
            return false;
        }
    }

    /**
     * 添加客服账号
     * @param [type] $account  [description]
     * @param [type] $nickname [description]
     * @param [type] $password [description]
     */
    public static function add($account, $nickname, $password)
    {
        $params = [
            'kf_account' => $account,
            'nickname'   => $nickname,
            'password'   => md5($password),
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        return Utils::api(self::$url['service_add'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    /**
     * 修改客服账号
     * @param  [type] $account  [description]
     * @param  [type] $nickname [description]
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public static function update($account, $nickname, $password)
    {
        $params = [
            'kf_account' => $account,
            'nickname'   => $nickname,
            'password'   => md5($password),
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        return Utils::api(self::$url['service_update'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    /**
     * 删除客服账号
     * @param  [type] $account [description]
     * @return [type]          [description]
     */
    public static function delete($account)
    {
        $params = [
            'kf_account'   => $account,
            'access_token' => parent::$config['access_token'],
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        return Utils::api(self::$url['service_delete'], $params);
    }

    /**
     * 获取客服聊天记录
     * @param  [type]  $starttime [description]
     * @param  [type]  $endtime   [description]
     * @param  integer $pageindex [description]
     * @param  integer $pagesize  [description]
     * @return [type]             [description]
     */
    public static function record($starttime, $endtime, $pageindex = 1, $pagesize = 50)
    {
        $params = [
            'starttime' => $starttime,
            'endtime'   => $endtime,
            'pageindex' => $pageindex,
            'pagesize'  => $pagesize,
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        $result = Utils::api(self::$url['msg_record'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
        if ($result) {
            return $result['recordlist'];
        } else {
            return false;
        }
    }

    /**
     * 发送客服消息
     * @param  [type] $openid
     * @param  [type] $type
     * @param  [type] $content
     * @return boolean
     */
    public static function send($openid, $type, $content)
    {
        $params = [
            'touser'  => $openid,
            'msgtype' => $type,
            'text'    => [
                'content' => $content,
            ],
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        return Utils::api(self::$url['custom_send'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    /**
     * 创建会话
     * @param  [type] $account 完整客服账号
     * @param  [type] $openid  客户openid
     * @param  string $text    附加信息，文本会展示在客服人员的多客服客户端
     * @return boolean
     */
    public static function session_create($account, $openid, $text = '')
    {
        $params = [
            'kf_account' => $account,
            'openid'     => $openid,
            'text'       => $text,
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        return Utils::api(self::$url['session_create'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    /**
     * 关闭会话
     * @param  [type] $account 完整客服账号
     * @param  [type] $openid  客户openid
     * @param  string $text    附加信息，文本会展示在客服人员的多客服客户端
     * @return boolean
     */
    public static function session_close($account, $openid, $text = '')
    {
        $params = [
            'kf_account' => $account,
            'openid'     => $openid,
            'text'       => $text,
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        return Utils::api(self::$url['session_close'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    /**
     * 获取客户的会话状态
     * @param  [type] $openid 客户openid
     * @return array
     */
    public static function session_get($openid)
    {
        $params = [
            'openid'       => $openid,
            'access_token' => parent::$config['access_token'],
        ];
        return Utils::api(self::$url['session_get'], $params);
    }

    /**
     * 获取客服的会话列表
     * @param  [type] $account [description]
     * @return [type]          [description]
     */
    public static function session_list($account)
    {
        $params = [
            'kf_account'   => $account,
            'access_token' => parent::$config['access_token'],
        ];
        $result = Utils::api(self::$url['session_list'], $params);
        if ($result) {
            return $result['sessionlist'];
        } else {
            return false;
        }
    }

    /**
     * 获取未接入会话列表
     * @return [type] [description]
     */
    public function session_wait()
    {
        $params = [
            'access_token' => parent::$config['access_token'],
        ];
        $result = Utils::api(self::$url['session_wait'], $params);
        if ($result) {
            return $result['waitcaselist'];
        } else {
            return false;
        }
    }
}
