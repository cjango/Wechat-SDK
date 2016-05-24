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
 * 被动消息回复
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
    public static function response($content, $type = 'text')
    {
        self::$response = [
            'ToUserName'   => self::$request['fromusername'],
            'FromUserName' => self::$request['tousername'],
            'CreateTime'   => time(),
            'MsgType'      => $type,
        ];

        self::$type($content);

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

    /**
     * 回复图文列表消息
     * @param  [type] $content [description]
     */
    private static function news($news)
    {
        $articles = [];

        foreach ($news as $key => $value) {
            list(
                $articles[$key]['Title'],
                $articles[$key]['Description'],
                $articles[$key]['PicUrl'],
                $articles[$key]['Url']
            ) = $value;
            if ($key >= 9) {
                break;
            }
        }

        self::$response['ArticleCount'] = count($articles);
        self::$response['Articles']     = $articles;
    }

    /**
     * 回复音乐信息
     * @param  string $content 要回复的音乐
     */
    private static function music($music)
    {
        list(
            $music['Title'],
            $music['Description'],
            $music['MusicUrl'],
            $music['HQMusicUrl']
        ) = $music;

        self::$response['Music'] = $music;
    }
}
