<?php


namespace Sczts\Sms\Handles;


use Illuminate\Support\Str;
use Sczts\Sms\Sms;
use Sczts\Sms\Exceptions\SmsException;

class Kyd implements Sms
{
    private $account;
    private $password;
    private $host;

    public function __construct()
    {
        $config = config('sms.handles.kyd');
        $this->account = $config['account'];
        $this->password = $config['password'];
        $this->host = $config['host'];
    }

    public function send($phone, $content)
    {
        $params = [
            'Account' => $this->account,
            'Password' => $this->password,
            'Mobile' => $phone,
            'Content' => $content,
            'Extnum' => '',
            'Time' => ''
        ];
        $url = Str::finish($this->host, '?') . http_build_query($params);
        $result = file_get_contents($url);
        return $this->checkResult($result);
    }

    private function checkResult($result)
    {
        if (substr($result, 0, 7) != 'SUCCESS') {
            $errors = [
                'ACCOUNTREG_ERR' => '用户账号未注册',
                'UNKNOWN_ERR' => '其他错误',
                'ACCOUNT_ERR' => '帐号或密码错误',
                'BALANCE_ERR' => '余额不足',
                'TIME_ERR' => '定时发送时间不是有效的时间格式',
                'SIGN_ERR' => '提交信息末尾未加签名，请添加中文的企业签名【 】',
                'CONTENT_ERR' => '发送内容需在1到500字之间',
                'PHONE_ERR' => '发送号码为空',
                'BLACK_IP' => '屏蔽手机号码',
                'BLACK_ACCOUNT' => '用户账号是黑名单',
                'IP_ERR' => 'IP 未导白',
                'PASSWORD_ERR' => '密码为空：请检查参数是否正确',
            ];
            if (key_exists($result, $errors)) {
                throw new SmsException($result . ':' . $errors[$result]);
            }
        }
        return true;
    }
}
