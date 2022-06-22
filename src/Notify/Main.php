<?php

namespace Buoor\Dingtalk\Notify;

use Illuminate\Support\Facades\Http;

class Main
{
    protected $url = 'https://oapi.dingtalk.com/topapi/message/corpconversation/asyncsend_v2';
    protected $mobile_search_url = 'https://oapi.dingtalk.com/topapi/v2/user/getbymobile';
    protected $token;

    public function __construct($token = '')
    {
        $this->token = $token;
    }

    protected function url()
    {
        return $this->url . '?access_token=' . $this->token;
    }

    protected function mobile_search_url()
    {
        return $this->mobile_search_url . '?access_token=' . $this->token;
    }

    public function markdown($title = '', $text = '')
    {
        $user_phones = [
            18624988212,
            // 15858251814,
            // 18867142017,
        ];
        $user_ids = [];
        array_map(function ($mobile) use (&$user_ids) {
            $response = Http::post($this->mobile_search_url(), [
                'mobile' => $mobile
            ])->json();

            array_push($user_ids, $response['result']['userid']);
        }, $user_phones);

        $user_ids = implode(',', $user_ids);

        $config = config('dingtalk');

        $msg = [
            "msgtype" => "link",
            "link" => [
                "messageUrl" => "https://bus.hidream.net",
                "picUrl" => "@lALOACZwe2Rk",
                "title" => $title,
                "text" => $text
            ]
        ];
        // dd($msg);
        $response = Http::post($this->url(), [
            'agent_id' => $config['agent_id'],
            'userid_list' => $user_ids,
            'msg' => $msg
        ])->json();

        if ($response['errcode'] != 0) {
        }
    }
}
