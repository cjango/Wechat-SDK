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
 * 数据统计接口
 */
class Datacube extends Wechat
{
    /**
     * 接口名称与URL映射
     * @var array
     */
    protected static $url = [
        'user_summary'  => 'https://api.weixin.qq.com/datacube/getusersummary',
        'user_cumulate' => 'https://api.weixin.qq.com/datacube/getusercumulate',
        ''              => 'https://api.weixin.qq.com/datacube/getarticlesummary',
        ''              => 'https://api.weixin.qq.com/datacube/getarticletotal',
        ''              => 'https://api.weixin.qq.com/datacube/getuserread',
        ''              => 'https://api.weixin.qq.com/datacube/getuserreadhour',
        ''              => 'https://api.weixin.qq.com/datacube/getusershare',
        ''              => 'https://api.weixin.qq.com/datacube/getusersharehour',
        ''              => 'https://api.weixin.qq.com/datacube/getupstreammsg',
        ''              => 'https://api.weixin.qq.com/datacube/getupstreammsghour',
        ''              => 'https://api.weixin.qq.com/datacube/getupstreammsgweek',
        ''              => 'https://api.weixin.qq.com/datacube/getupstreammsgmonth',
        ''              => 'https://api.weixin.qq.com/datacube/getupstreammsgdist',
        ''              => 'https://api.weixin.qq.com/datacube/getupstreammsgdistweek',
        ''              => 'https://api.weixin.qq.com/datacube/getupstreammsgdistmonth',
        ''              => 'https://api.weixin.qq.com/datacube/getinterfacesummary',
        ''              => 'https://api.weixin.qq.com/datacube/getinterfacesummaryhour',
    ];
}
