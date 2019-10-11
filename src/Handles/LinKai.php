<?php

namespace Sczts\Sms\Handles;

use Sczts\Sms\Sms;

class LinKai implements Sms
{

    private $id;
    private $pwd;
    private $host;

    public function __construct()
    {
        $config = config('sms.handles.lin_kai');

        $this->id = $config['id'];
        $this->pwd = $config['pwd'];
        $this->host = $config['host'];
    }

    public function send($phone,$content)
    {
        $content = rawurlencode(mb_convert_encoding($content, "gb2312", "utf-8"));
        $uri = "{$this->host}?CorpID={$this->id}&Pwd={$this->pwd}&Mobile={$phone}&Content={$content}&Cell=&SendTime=";
        $result = $this->curl($uri);
        return $this->checkResult($result);
    }

    private function curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "x-sdk-client" => "php/2.0.0"
        ));
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $rtn = curl_exec($ch);

        if ($rtn === false) {
            trigger_error("[CURL_" . curl_errno($ch) . "]: " . curl_error($ch), E_USER_ERROR);
        }

        curl_close($ch);

        return $rtn;
    }

    private function checkResult($result)
    {
        $error = [
            "–1" => "账号未注册",
            "–2" => "网络访问超时，请稍后再试",
            "–3" => "帐号或密码错误",
            "–4" => "只支持单发",
            "–5" => "余额不足，请充值",
            "–6" => "定时发送时间不是有效的时间格式",
            "–7" => "提交信息末尾未加签名，请添加中文的企业签名【 】或未采用gb2312编码",
            "–8" => "发送内容需在1到300字之间",
            "–9" => "发送号码为空",
            "-10" => "定时时间不能小于系统当前时间",
            "-11" => "屏蔽手机号码",
            "-101" => "调用接口速度太快",
        ];
        if(in_array($result,$error)){
            return $error[$result];
        }else{
            return false;
        }
    }
}
