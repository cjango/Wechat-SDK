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
 * 微信卡券相关部分，太难了 等我喝醉了再说吧！
 */
class Card extends Wechat
{
    /**
     * 接口名称与URL映射
     * @var array
     */
    protected static $url = [
        'card_create' => 'https://api.weixin.qq.com/card/create',
        'card_active' => 'https://api.weixin.qq.com/card/membercard/activate',
    ];

    public static function create()
    {
        $params = [
            'card' => [
                'card_type'   => 'MEMBER_CARD',
                'member_card' => [
                    'base_info' => [
                        'logo_url'   => '',
                        'brand_name' => '',
                        'code_type'  => 'CODE_TYPE_TEXT',
                        'title'      => 'Color010',
                    ],
                ],
            ],
        ];
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        return Utils::api(self::$url['card_create'] . '?access_token=' . parent::$config['access_token'], $params, 'POST');
    }

    public static function active()
    {
        #Todo..
    }
}
