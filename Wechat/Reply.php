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
        // 它说是POST,然并卵..
        $postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : null;

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

    /**
     * 回复图片消息
     * @param  [type] $media_id [description]
     */
    public static function image($media_id)
    {
        self::$response['Image']['MediaId'] = $media_id;
    }

    /**
     * 回复图片消息
     * @param  [type] $media_id [description]
     */
    public static function voice($media_id)
    {
        self::$response['Voice']['MediaId'] = $media_id;
    }

    /**
     * 回复视频消息
     * @return [type] [description]
     */
    public static function video($media_id, $title, $description = '')
    {
        self::$response['Video']['MediaId']     = $media_id;
        self::$response['Video']['Title']       = $title;
        self::$response['Video']['Description'] = $description;
    }

    /**
     * 回复音乐消息
     * @param  [type] $title        [description]
     * @param  [type] $description  [description]
     * @param  [type] $music_url    [description]
     * @param  [type] $hq_music_url [description]
     * @param  [type] $media_id     [description]
     * @return [type]               [description]
     */
    public function music($title, $description, $music_url, $hq_music_url, $media_id)
    {
        self::$response['Music']['Title']        = $title;
        self::$response['Music']['Description']  = $description;
        self::$response['Music']['MusicUrl']     = $music_url;
        self::$response['Music']['HQMusicUrl']   = $hq_music_url;
        self::$response['Music']['ThumbMediaId'] = $media_id;
    }

    /**
     * 回复图文消息
     * @param  [type] $news $content[] = [$title, $description, $cover, $url];
     * @return [type]       [description]
     */
    public static function articles($news)
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
            } //最多只允许10条新闻
        }
        self::$response['ArticleCount'] = count($articles);
        self::$response['Articles']     = $articles;
    }
}
