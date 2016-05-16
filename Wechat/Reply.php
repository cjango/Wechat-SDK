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
 *
 */
class Reply extends Wechat
{

    /**
     * 接收到的消息内容
     * @var array
     */
    private static $request = [];

    private static $response = [];

    /**
     * 接受消息,通用,接受到的消息
     * 用户自己处理消息类型就可以
     * 暂时不处理加密问题
     * @return array|boolean
     */
    public static function request()
    {
        $postStr = file_get_contents("php://input");

        if (!empty($postStr)) {
            $data                 = Utils::xml2array($postStr);
            return self::$request = $data;
        } else {
            return false;
        }
    }

    /**
     * 回复消息
     * @param  [type] $content [description]
     * @param  string $type    [description]
     * @return [type]          [description]
     */
    public static function reply($content, $type = 'text')
    {
        /* 基础数据 */
        self::$response = [
            'ToUserName'   => self::$request['fromusername'],
            'FromUserName' => self::$request['tousername'],
            'CreateTime'   => time(),
            'MsgType'      => $type,
        ];
        /* 添加类型数据 */
        self::$type($content);
        /* 转换数据为XML */
        $response = Utils::array2xml(self::$response);
        exit($response);
    }

    /**
     * 回复文本类型消息
     * @param  string $content
     */
    private static function text($content)
    {
        self::$response['Content'] = $content;
    }
}
