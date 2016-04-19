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
 * 分组管理
 */
class Group extends Wechat
{

    /**
     * 接口名称与URL映射
     * @var array
     */
    protected static $url = [
        'group_get'    => 'https://api.weixin.qq.com/cgi-bin/groups/get',
        'group_create' => 'https://api.weixin.qq.com/cgi-bin/groups/create',
        'group_update' => 'https://api.weixin.qq.com/cgi-bin/groups/update',
        'group_delete' => 'https://api.weixin.qq.com/cgi-bin/groups/delete',
    ];

    /**
     * 获取全部分组
     */
    public static function get()
    {
        $params = [
            'access_token' => parent::$config['access_token'],
        ];
        $result = Utils::api(self::$url['group_get'], $params);
        if ($result) {
            return $result['groups'];
        } else {
            return false;
        }
    }

    /**
     * 新增分组
     * @param  string $name
     * @return array ['id' => ID, 'name' => NAME]
     */
    public static function create($name)
    {
        $params = [
            'group' => [
                'name' => $name,
            ],
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        $result = Utils::api(self::$url['group_create'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
        if ($result) {
            return $result['group'];
        } else {
            return false;
        }
    }

    /**
     * 修改分组名
     * @param  [type] $id   [description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public static function update($id, $name)
    {
        $params = [
            'group' => [
                'id'   => $id,
                'name' => $name,
            ],
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        return Utils::api(self::$url['group_update'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    /**
     * 删除分组
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function delete($id)
    {
        $params = [
            'group' => [
                'id' => $id,
            ],
        ];
        $params = json_encode($params);
        return Utils::api(self::$url['group_delete'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }
}
