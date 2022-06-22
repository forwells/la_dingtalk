<?php

namespace Buoor\Dingtalk;

use AlibabaCloud\SDK\Dingtalk\Vedu_1_0\Models\QueryClassScheduleResponseBody\config;
use Buoor\Dingtalk\Notify\Main;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Dingtalk
{
    protected $token_url = 'https://oapi.dingtalk.com/gettoken';
    public function __construct()
    {
        $app_key = config('dingtalk.app_key');
        $app_secret = config('dingtalk.app_secret');

        if (!Cache::get($app_key)) {
            $response = Http::get($this->token_url, [
                'appkey' => $app_key,
                'appsecret' => $app_secret
            ])->json();
            if ($response['errcode'] == 0) {
                Cache::add($app_key, $response['access_token'], $response['expires_in']);
            }
        }
    }

    public function notify()
    {
        return new Main($this->accessToken());
    }

    public function accessToken()
    {
        return Cache::get(config('dingtalk.app_key'));
    }
}
