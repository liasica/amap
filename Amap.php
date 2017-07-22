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
    const GEOCODE_REGEO  = 'geocode/regeo';

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
        $ret = $this->httpGet(self::API_PLACE_TEXT, array_merge([
            'keyword' => $keywords,
            'types'   => $types,
        ], $params));
        if ($ret['status'] != 1) {
            return false;
        }
        return $ret['pois'];
    }

    /**
     * 逆地理编码
     * @param       $location
     * @param array $params
     * @return array|bool
     */
    public function geocodeRegeo($location, array $params = [])
    {
        $ret = $this->httpGet(self::GEOCODE_REGEO, array_merge([
            'location' => $location,
        ], $params));
        if ($ret['status'] != 1 || !isset($ret['regeocode']['addressComponent']['businessAreas'])) {
            return false;
        }
        return $ret;
    }

}