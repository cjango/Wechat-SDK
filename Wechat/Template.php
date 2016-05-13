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

    /**
     * 设置所属行业
     * @param [type] $industry1 [description]
     * @param [type] $industry2 [description]
     */
    public static function setIndustry($primary, $secondary)
    {
        $params = [
            'industry_id1' => $primary,
            'industry_id2' => $secondary,
        ];
        $params = json_encode($params);
        return Utils::api(self::$url['set_industry'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    /**
     * 获取设置的行业信息
     * @return [type] [description]
     */
    public static function getIndustry()
    {
        return Utils::api(self::$url['get_industry'] . '?access_token=' . parent::$config['access_token'], '', 'GET');
    }

    /**
     * 获得模板ID
     * @return [type] [description]
     */
    public static function add($shortTemplateId)
    {
        $params = [
            'template_id_short' => $shortTemplateId,
        ];
        $params = json_encode($params);
        return Utils::api(self::$url['add_template'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    /**
     * 获取模板列表
     * @return [type] [description]
     */
    public static function get()
    {
        return Utils::api(self::$url['get_template'] . '?access_token=' . parent::$config['access_token'], '', 'GET');
    }

    /**
     * 删除模板
     * @param  [type] $templateId 长模板ID 例：Dyvp3-Ff0cnail_CDSzk1fIc6-9lOkxsQE7exTJbwUE
     * @return boolean
     */
    public static function delete($templateId)
    {
        $params = [
            'template_id' => $templateId,
        ];
        $params = json_encode($params);
        return Utils::api(self::$url['del_template'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    /**
     * 发送模板消息
     * @param  [type] $openid     接收用户
     * @param  [type] $templateId 模板ID
     * @param  array  $data       消息体
     * @param  string $url        连接URL
     * @return boolean
     */
    public static function send($openid, $templateId, $data = [], $url = '')
    {
        $params = [
            'touser'      => $openid,
            'template_id' => $templateId,
            'url'         => $url,
            'data'        => $data,
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        return Utils::api(self::$url['send_template'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }
}
