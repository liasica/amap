<?php
/**
 * Author: liasica
 * Email: magicrolan@qq.com
 * CreateTime: 2017/3/18 下午3:10
 */

namespace liasica\amap\base;

use yii\base\Component;
use yii\base\InvalidConfigException;

abstract class BaseAmap extends Component
{
    const AMAP_API_HOST = 'https://restapi.amap.com/v3/';
    public $key;

    public function init()
    {
        parent::init();

        if ($this->key == null) {
            throw new InvalidConfigException('amap must need key!');
        }
    }

    /**
     * GET请求数据
     * @param       $api
     * @param array $params
     * @return array|bool
     */
    public function httpGet($api, array $params = [])
    {
        $url = $this->getUrl($api, $params);
        return $this->request($url);
    }

    /**
     * 拼接请求URL
     * @param $api
     * @param $params
     * @return string
     */
    public function getUrl($api, $params)
    {
        $url = strpos($api, 'https://') === false && strpos($api, 'http://') === false ?
            self::AMAP_API_HOST . $api . '?key=' . $this->key :
            $api . '?key=' . $this->key;
        return $url . '&' . http_build_query($params);
    }

    /**
     * 请求
     * @param       $url
     * @param array $options
     * @return bool|array
     */
    protected function request($url, $options = [])
    {
        $options = [
                       CURLOPT_URL            => $url,
                       CURLOPT_TIMEOUT        => 30,
                       CURLOPT_CONNECTTIMEOUT => 30,
                       CURLOPT_RETURNTRANSFER => true,
                   ] + (stripos($url, 'https://') !== false ? [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSLVERSION     => CURL_SSLVERSION_TLSv1,
            ] : []) + $options;
        $curl    = curl_init();
        curl_setopt_array($curl, $options);
        $content = curl_exec($curl);
        $status  = curl_getinfo($curl);
        curl_close($curl);
        if (isset($status['http_code']) && $status['http_code'] == 200) {
            // 只返回json字符串
            return json_decode($content, true) ?: false;
        }
        Yii::error([
            'result' => $content,
            'status' => $status,
        ], __METHOD__);
        return false;
    }

    /**
     * POST请求数据
     * @param       $api
     * @param array $params
     * @param array $data
     * @return array|bool
     */
    public function httpPost($api, array $params = [], array $data = [])
    {
        return $this->request($this->getUrl($api, $params), [
            CURLOPT_POST       => true,
            CURLOPT_POSTFIELDS => $data,
        ]);
    }
}
