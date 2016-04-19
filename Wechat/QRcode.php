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
 * 自定义菜单
 */
class QRcode extends Wechat
{

    /**
     * 接口名称与URL映射
     * @var array
     */
    protected static $url = [
        'qrcode_create' => 'https://api.weixin.qq.com/cgi-bin/qrcode/create',
        'qrcode_show'   => 'https://mp.weixin.qq.com/cgi-bin/showqrcode',
    ];

    /**
     * 临时二维码
     * @param  [type]  $scene_id [description]
     * @param  integer $expire   [description]
     * @return [type]            [description]
     */
    public static function temp($scene_id, $expire = 604800)
    {
        $params = [
            'expire_seconds' => $expire,
            'action_name'    => 'QR_SCENE',
            'action_info'    => [
                'scene' => [
                    'scene_id' => $scene_id,
                ],
            ],
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        $result = Utils::api(self::$url['qrcode_create'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
        if ($result) {
            return self::$url['qrcode_show'] . '?ticket=' . $result['ticket'];
        } else {
            return false;
        }
    }

    /**
     * 永久二维码
     * @return [type] [description]
     */
    public static function limit($scene_str)
    {
        $params = [
            'action_name' => 'QR_LIMIT_SCENE',
            'action_info' => [
                'scene' => [
                    'scene_str' => $scene_str,
                ],
            ],
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        $result = Utils::api(self::$url['qrcode_create'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
        if ($result) {
            return self::$url['qrcode_show'] . '?ticket=' . $result['ticket'];
        } else {
            return false;
        }
    }
}
