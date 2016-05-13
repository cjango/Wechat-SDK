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
class Utils
{
    /**
     * 错误信息
     * @var array
     */
    private static $errMsg = [
        -1      => '系统繁忙，此时请开发者稍候再试',
        0       => '请求成功',
        40001   => '获取access_token时AppSecret错误，或者access_token无效。请开发者认真比对AppSecret的正确性，或查看是否正在为恰当的公众号调用接口',
        40002   => '不合法的凭证类型',
        40003   => '不合法的OpenID，请开发者确认OpenID（该用户）是否已关注公众号，或是否是其他公众号的OpenID',
        40004   => '不合法的媒体文件类型',
        40005   => '不合法的文件类型',
        40006   => '不合法的文件大小',
        40007   => '不合法的媒体文件id',
        40008   => '不合法的消息类型',
        40009   => '不合法的图片文件大小',
        40010   => '不合法的语音文件大小',
        40011   => '不合法的视频文件大小',
        40012   => '不合法的缩略图文件大小',
        40013   => '不合法的AppID，请开发者检查AppID的正确性，避免异常字符，注意大小写',
        40014   => '不合法的access_token，请开发者认真比对access_token的有效性（如是否过期），或查看是否正在为恰当的公众号调用接口',
        40015   => '不合法的菜单类型',
        40016   => '不合法的按钮个数',
        40017   => '不合法的按钮个数',
        40018   => '不合法的按钮名字长度',
        40019   => '不合法的按钮KEY长度',
        40020   => '不合法的按钮URL长度',
        40021   => '不合法的菜单版本号',
        40022   => '不合法的子菜单级数',
        40023   => '不合法的子菜单按钮个数',
        40024   => '不合法的子菜单按钮类型',
        40025   => '不合法的子菜单按钮名字长度',
        40026   => '不合法的子菜单按钮KEY长度',
        40027   => '不合法的子菜单按钮URL长度',
        40028   => '不合法的自定义菜单使用用户',
        40029   => '不合法的oauth_code',
        40030   => '不合法的refresh_token',
        40031   => '不合法的openid列表',
        40032   => '不合法的openid列表长度',
        40033   => '不合法的请求字符，不能包含\uxxxx格式的字符',
        40035   => '不合法的参数',
        40038   => '不合法的请求格式',
        40039   => '不合法的URL长度',
        40050   => '不合法的分组id',
        40051   => '分组名字不合法',
        40117   => '分组名字不合法',
        40118   => 'media_id大小不合法',
        40119   => 'button类型错误',
        40120   => 'button类型错误',
        40121   => '不合法的media_id类型',
        40132   => '微信号不合法',
        40137   => '不支持的图片格式',
        41001   => '缺少access_token参数',
        41002   => '缺少appid参数',
        41003   => '缺少refresh_token参数',
        41004   => '缺少secret参数',
        41005   => '缺少多媒体文件数据',
        41006   => '缺少media_id参数',
        41007   => '缺少子菜单数据',
        41008   => '缺少oauth code',
        41009   => '缺少openid',
        42001   => 'access_token超时，请检查access_token的有效期',
        42002   => 'refresh_token超时',
        42003   => 'oauth_code超时',
        42007   => '用户修改微信密码，accesstoken和refreshtoken失效，需要重新授权',
        43001   => '需要GET请求',
        43002   => '需要POST请求',
        43003   => '需要HTTPS请求',
        43004   => '需要接收者关注',
        43005   => '需要好友关系',
        44001   => '多媒体文件为空',
        44002   => 'POST的数据包为空',
        44003   => '图文消息内容为空',
        44004   => '文本消息内容为空',
        45001   => '多媒体文件大小超过限制',
        45002   => '消息内容超过限制',
        45003   => '标题字段超过限制',
        45004   => '描述字段超过限制',
        45005   => '链接字段超过限制',
        45006   => '图片链接字段超过限制',
        45007   => '语音播放时间超过限制',
        45008   => '图文消息超过限制',
        45009   => '接口调用超过限制',
        45010   => '创建菜单个数超过限制',
        45015   => '回复时间超过限制',
        45016   => '系统分组，不允许修改',
        45017   => '分组名字过长',
        45018   => '分组数量超过上限',
        45047   => '客服接口下行条数超过上限',
        46001   => '不存在媒体数据',
        46002   => '不存在的菜单版本',
        46003   => '不存在的菜单数据',
        46004   => '不存在的用户',
        47001   => '解析JSON/XML内容错误',
        48001   => 'api功能未授权，请确认公众号已获得该接口，可以在公众平台官网-开发者中心页中查看接口权限',
        48004   => 'api接口被封禁，请登录mp.weixin.qq.com查看详情',
        48005   => 'api禁止删除被自动回复和自定义菜单引用的素材',
        48006   => 'api禁止清零调用次数，因为清零次数达到上限',
        50001   => '用户未授权该api',
        50002   => '用户受限，可能是违规后接口被封禁',
        61450   => '客服系统错误',
        61451   => '参数错误',
        61452   => '无效客服账号',
        61453   => '客服帐号已存在',
        61454   => '客服帐号名长度超过限制(仅允许10个英文字符，不包括@及@后的公众号的微信号)',
        61455   => '客服帐号名包含非法字符(仅允许英文+数字)',
        61456   => '客服帐号个数超过限制(10个客服账号)',
        61457   => '无效头像文件类型',
        61458   => '客户正在被其他客服接待',
        61459   => '客服不在线',
        61500   => '日期格式错误',
        65301   => '不存在此menuid对应的个性化菜单',
        65302   => '没有相应的用户',
        65303   => '没有默认菜单，不能创建个性化菜单',
        65304   => 'MatchRule信息为空',
        65305   => '个性化菜单数量受限',
        65306   => '不支持个性化菜单的帐号',
        65307   => '个性化菜单信息为空',
        65308   => '包含没有响应类型的button',
        65309   => '个性化菜单开关处于关闭状态',
        65310   => '填写了省份或城市信息，国家信息不能为空',
        65311   => '填写了城市信息，省份信息不能为空',
        65312   => '不合法的国家信息',
        65313   => '不合法的省份信息',
        65314   => '不合法的城市信息',
        65316   => '该公众号的菜单设置了过多的域名外跳（最多跳转到3个域名的链接）',
        65317   => '不合法的URL',
        9001001 => 'POST数据参数不合法',
        9001002 => '远端服务不可用',
        9001003 => 'Ticket不合法',
        9001004 => '获取摇周边用户信息失败',
        9001005 => '获取商户信息失败',
        9001006 => '获取OpenID失败',
        9001007 => '上传文件缺失',
        9001008 => '上传素材的文件类型不合法',
        9001009 => '上传素材的文件尺寸不合法',
        9001010 => '上传失败',
        9001020 => '帐号不合法',
        9001021 => '已有设备激活率低于50%，不能新增设备',
        9001022 => '设备申请数不合法，必须为大于0的数字',
        9001023 => '已存在审核中的设备ID申请',
        9001024 => '一次查询设备ID数量不能超过50',
        9001025 => '设备ID不合法',
        9001026 => '页面ID不合法',
        9001027 => '页面参数不合法',
        9001028 => '一次删除页面ID数量不能超过10',
        9001029 => '页面已应用在设备中，请先解除应用关系再删除',
        9001030 => '一次查询页面ID数量不能超过50',
        9001031 => '时间区间不合法',
        9001032 => '保存设备与页面的绑定关系参数错误',
        9001033 => '门店ID不合法',
        9001034 => '设备备注信息过长',
        9001035 => '设备申请参数不合法',
        9001036 => '查询起始值begin不合法',
    ];

    /**
     * 返回数据结果集
     * @var mixed
     */
    public static $result;

    public static function api($url, $params = [], $method = 'GET')
    {
        $result = self::http($url, $params, $method);
        return self::parseRequestJson($result);
    }

    /**
     * 发送HTTP请求方法，目前只支持CURL发送请求
     * @param  string  $url    请求URL
     * @param  array   $params 请求参数
     * @param  string  $method 请求方法GET/POST
     * @param  boolean $ssl    是否进行SSL双向认证
     * @return array   $data   响应数据
     */
    public static function http($url, $params = [], $method = 'GET', $ssl = false)
    {
        $opts = [
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ];
        /* 根据请求类型设置特定参数 */
        switch (strtoupper($method)) {
            case 'GET':
                $getQuerys         = !empty($params) ? '?' . urldecode(http_build_query($params)) : '';
                $opts[CURLOPT_URL] = $url . $getQuerys;
                break;
            case 'POST':
                $opts[CURLOPT_URL]        = $url;
                $opts[CURLOPT_POST]       = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data   = curl_exec($ch);
        $err    = curl_errno($ch);
        $errmsg = curl_error($ch);
        curl_close($ch);
        if ($err > 0) {
            \tools\Wechat::error('CURL:' . $errmsg);
            return false;
        } else {
            return $data;
        }
    }

    /**
     * XML文档解析成数组，并将键值转成小写
     * @param  xml   $xml
     * @return array
     */
    public static function xml2array($xml)
    {
        $data = (array) simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        return array_change_key_case($data, CASE_LOWER);
    }

    /**
     * 将数组转换成XML
     * @param  array $array
     * @return xml
     */
    public static function array2xml($array = [])
    {
        $xml = new \SimpleXMLElement('<xml></xml>');
        self::_data2xml($xml, $array);
        return $xml->asXML();
    }

    /**
     * 数据XML编码
     * @param  xml    $xml  XML对象
     * @param  mixed  $data 数据
     * @param  string $item 数字索引时的节点名称
     * @return string xml
     */
    private static function _data2xml($xml, $data, $item = 'item')
    {
        foreach ($data as $key => $value) {
            is_numeric($key) && $key = $item;
            if (is_array($value) || is_object($value)) {
                $child = $xml->addChild($key);
                self::_data2xml($child, $value, $item);
            } else {
                if (is_numeric($value)) {
                    $child = $xml->addChild($key, $value);
                } else {
                    $child = $xml->addChild($key);
                    $node  = dom_import_simplexml($child);
                    $node->appendChild($node->ownerDocument->createCDATASection($value));
                }
            }
        }
    }

    /**
     * 解析返回的json数据
     * @param  [type] $json
     * @return
     */
    private static function parseRequestJson($json)
    {
        $result = json_decode($json, true);
        if (isset($result['errcode'])) {
            if ($result['errcode'] == 0) {
                self::$result = $result;
                return true;
            } else {
                Wechat::error(self::parseError($result));
                return false;
            }
        } else {
            return $result;
        }
    }

    /**
     * 解析错误信息
     * @param  array  $result
     * @return string
     */
    public static function parseError($result)
    {
        $code = $result['errcode'];
        return '[' . $code . '] ' . self::$errMsg[$code];
    }
}
