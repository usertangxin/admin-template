<?php

namespace Modules\Map\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Http\Controllers\AbstractController;
use Modules\Admin\Services\SystemConfigService;

#[SystemMenu('地图')]
class IndexController extends AbstractController
{
    #[SystemMenu('腾讯地图配置', allow_admin: true, is_hidden: true,)]
    public function getTencentConfig(SystemConfigService $systemConfigService)
    {
        $config = $systemConfigService->getConfigByKey('map_tencent_key');

        return $this->success([
            'key' => $config['value'],
        ]);
    }

    #[SystemMenu('高德地图配置', allow_admin: true, is_hidden: true,)]
    public function getAmapConfig(SystemConfigService $systemConfigService)
    {
        $config = $systemConfigService->getConfigByKey('map_amap_key');

        return $this->success([
            'key' => $config['value'],
        ]);
    }

    /**
     * 高德地图服务代理（转发请求到高德API）
     */
    #[SystemMenu('高德地图服务代理', allow_admin: true, is_hidden: true,)]
    public function amapServiceProxy(Request $request, SystemConfigService $systemConfigService)
    {
        // 获取高德JSAPI安全密钥
        $code           = $systemConfigService->getConfigByKey('map_amap_code')['value'];
        // 当前请求路径（如：/_AMapService/v3/geocode/geo）
        $path           = $request->path();
        // 请求参数（如：address=北京市）
        $args           = $request->query();
        // 注入安全密钥（用于高德JSAPI校验）
        $args['jscode'] = $code;
        // 移除路径中的代理标识（/_AMapService）
        $re_path        = str_replace('/web/map/_AMapService', '', $path);
        // 拼接完整参数（如：v3/geocode/geo?address=北京市&jscode=xxx）
        $re_path        = $re_path . '?' . http_build_query($args);

        // 定义不同路径前缀对应的高德服务域名映射
        $re = [
            '/web/map/_AMapService/v4/map/styles' => 'https://webapi.amap.com' . $re_path,
            '/web/map/_AMapService/v3/vectormap'  => 'https://fmap01.amap.com' . $re_path,
            '/web/map/_AMapService/'              => 'https://restapi.amap.com' . $re_path,
        ];

        // 根据请求路径匹配目标域名
        $host = '';
        foreach ($re as $key => $value) {
            if (str_starts_with($path, $key)) {
                $host = $value;
                break;
            }
        }

        // 使用Guzzle发起代理请求（跳过SSL验证，超时10秒）
        $client = new Client([
            'verify'  => false,
            'timeout' => 10,
        ]);
        $result = $client->request($request->method(), $host, [
            'headers' => $request->header(),
        ]);

        // 构造响应（移除Content-Length头部避免长度不匹配问题）
        $headers = $result->getHeaders();
        unset($headers['Content-Length']);

        return Response::make($result->getBody()->getContents(), $result->getStatusCode(), $headers);
    }
}
