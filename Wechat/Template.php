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
 * 模板消息
 */
class Template extends Wechat
{

    /**
     * 接口名称与URL映射
     * @var array
     */
    protected static $url = [
        'set_industry'  => 'https://api.weixin.qq.com/cgi-bin/template/api_set_industry', // 设置所属行业
        'get_industry'  => 'https://api.weixin.qq.com/cgi-bin/template/get_industry', // 获取设置的行业信息
        'add_template'  => 'https://api.weixin.qq.com/cgi-bin/template/api_add_template', // 获得模板ID
        'get_template'  => 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template', // 获取模板列表
        'del_template'  => 'https://api.weixin.qq.com/cgi-bin/template/del_private_template', // 删除模板
        'send_template' => 'https://api.weixin.qq.com/cgi-bin/message/template/send', // 发送模板消息
    ];

}
