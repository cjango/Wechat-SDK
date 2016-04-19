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
        'get_kf_list'        => 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist',
        'get_online_kf_list' => 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist',
        'add_kf'             => 'https://api.weixin.qq.com/customservice/kfaccount/add',
        'update_kf'          => 'https://api.weixin.qq.com/customservice/kfaccount/update',
        'delete_kf'          => 'https://api.weixin.qq.com/customservice/kfaccount/del',
        'upload_kf_headimg'  => 'Http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg',
        'get_kf_msgrecord'   => 'https://api.weixin.qq.com/customservice/msgrecord/getrecord',
    ];
}
