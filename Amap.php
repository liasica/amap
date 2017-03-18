<?php
/**
 * Author: liasica
 * Email: magicrolan@qq.com
 * CreateTime: 2017/3/18 下午4:23
 */

namespace liasica\amap;

use liasica\amap\base\BaseAmap;

class Amap extends BaseAmap
{
    const API_PLACE_TEXT = 'place/text';

    /**
     * 关键字搜索
     * @param       $keywords
     * @param       $types
     * @param array $params
     * @link http://lbs.amap.com/api/webservice/guide/api/search#text
     * @return array|bool
     */
    public function placeText($keywords, $types, array $params = [])
    {
        return $this->httpGet(self::API_PLACE_TEXT, array_merge([
            'keyword' => $keywords,
            'types'   => $types,
        ], $params));
    }


}