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
 * 素材管理
 */
class Material extends Wechat
{
    /**
     * 接口名称与URL映射
     * @var array
     */
    protected static $url = [
        'media_upload'      => 'https://api.weixin.qq.com/cgi-bin/media/upload', // 新增临时素材
        'media_get'         => 'https://api.weixin.qq.com/cgi-bin/media/get', // 获取临时素材
        'material_news'     => 'https://api.weixin.qq.com/cgi-bin/material/add_news', // 新增永久图文素材
        'material_material' => 'https://api.weixin.qq.com/cgi-bin/material/add_material', // 新增永久素材
        'material_get'      => 'https://api.weixin.qq.com/cgi-bin/material/get_material', // 获取永久素材
        'material_del'      => 'https://api.weixin.qq.com/cgi-bin/material/del_material', // 删除永久素材
        'material_update'   => 'https://api.weixin.qq.com/cgi-bin/material/update_news', // 修改永久图文素材
        'material_count'    => 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount', // 获取永久素材数量
        'material_lists'    => 'https://api.weixin.qq.com/cgi-bin/material/batchget_material', // 获取永久素材列表
    ];

    /**
     * 新增临时素材
     * @return [type] [description]
     */
    public static function upload()
    {
        #Todo..
    }

    /**
     * 获取临时素材
     * @return [type] [description]
     */
    public static function get()
    {
        #Todo..
    }
}
