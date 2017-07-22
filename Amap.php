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
    const API_PLACE_TEXT  = 'place/text';
    const GEOCODE_REGEO   = 'geocode/regeo';
    const GEOFENCE_STATUS = 'https://restapi.amap.com/v4/geofence/status';

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

    /**
     * @param      $diu       用户设备唯一标识符，Android为imei，iOS为idfv
     * @param      $locations 设备位置坐标组,包含坐标数据和坐标产生的时间戳数据。 判定依据：最新的点 作为当前，然后从距离当前点10s～一小时 范围内选出最早点
     *                        格式: x1,y1,unix_ts;x2,y2,unix_ts
     * @param null $uid
     */
    public function geofenceStatus($diu, $locations, $uid = null)
    {
        $ret = $this->httpGet(self::GEOFENCE_STATUS, [
            'diu'       => $diu,
            'locations' => $locations,
            'uid'       => $uid,
            'imei'      => $diu,
        ]);
        var_dump($ret);
        exit();
    }

}