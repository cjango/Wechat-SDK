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
class Menu extends Wechat
{
    /**
     * 接口名称与URL映射
     * @var array
     */
    protected static $url = [
        'menu_get'    => 'https://api.weixin.qq.com/cgi-bin/menu/get', // 获取菜单
        'menu_create' => 'https://api.weixin.qq.com/cgi-bin/menu/create', // 创建菜单
        'menu_delete' => 'https://api.weixin.qq.com/cgi-bin/menu/delete', // 删除菜单
    ];

    /**
     * 获取自定义菜单
     * @return [type] [description]
     */
    public static function get()
    {
        $params = [
            'access_token' => parent::$config['access_token'],
        ];
        $result = Utils::api(self::$url['menu_get'], $params);
        if ($result) {
            return $result['menu']['button'];
        } else {
            return false;
        }
    }

    /**
     * 创建菜单
     * @param  [type] $menu [description]
     * @return [type]        [description]
     */
    public static function create($menu)
    {
        $params = [
            'button' => $menu,
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        return Utils::api(self::$url['menu_create'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    /**
     * 删除自定义菜单
     * @return [type] [description]
     */
    public static function delete()
    {
        $params = [
            'access_token' => parent::$config['access_token'],
        ];
        return Utils::api(self::$url['menu_delete'], $params);
    }
}
