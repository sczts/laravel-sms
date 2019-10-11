<?php


namespace Sczts\Sms;

use Sczts\Sms\SmsException;
use Illuminate\Support\Facades\Redis;

class SmsService
{
    private $handler;
    private $config;

    public function __construct()
    {
        $default = config('sms.default');
        $this->config = config('sms.captcha');
        $this->handler = static::getHandle($default);
    }


    /**
     * 直接发送信息
     * @param $phone
     * @param $content
     * @return bool
     */
    public function send($phone,$content)
    {
        return $this->handler->send($phone,$content);
    }

    /**
     * 发送模板内容
     * @param $phone
     * @param $type
     * @param $data
     * @return bool
     */
    public function sendTemplate($phone,$type,$data = [])
    {
        if (!in_array('captcha',$data)){
            $data['captcha'] = $this->setCaptcha($phone,$type);
        }
        if (!in_array('expire',$data)){
            $data['expire'] = $this->config['expire'];
        }
        $content = $this->template($type,$data);
        return $this->send($phone,$content);
    }


    /**
     * 检查验证码是否正确
     * @param $phone
     * @param $code
     * @param $type
     * @return bool
     */
    public function checkCaptcha($phone,$code,$type)
    {
        $key = $this->config['prefix'].':'.$phone.':'.$type;
        $result = Redis::get($key) == $code;
        if ($result){
            Redis::del($key);
            return true;
        }
        return false;
    }

    /**
     * 设置验证码
     * @param $phone
     * @param $type
     * @param $length
     * @return string
     */
    public function setCaptcha($phone,$type,$length = 6)
    {
        $code = $this->random($length);
        $key = $this->config['prefix'].':'.$phone.':'.$type;
        $expire = $this->config['expire'] * 60;
        Redis::set($key,$code);
        Redis::expire($key,$expire);
        return $code;
    }


    /**
     * 生成指定长度的随机数
     * @param $length
     * @return string
     */
    private function random($length)
    {
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= rand(0, 9);
        }
        return $result;
    }


    /**
     * 生成模板内容
     * @param $type
     * @param $data
     * @return mixed
     * @throws SmsException
     */
    private function template($type,$data){
        $templates = config('sms.templates');
        if (!key_exists($type,$templates)){
            throw new SmsException('模板 '.$type.' 未定义');
        }
        $content = $templates[$type];
        preg_match_all('/{(\w.*?)}/',$content,$match);
        $keys = $match[1];
        foreach ($keys as $key){
            if (!key_exists($key,$data)){
                throw new SmsException('验证码模板参数 '.$key.' 未定义');
            }
            $content = str_replace('{'.$key.'}',$data[$key],$content);
        }
        return $content;
    }


    /**
     * 根据 $type 获取 Handles 目录下的登录实例
     * @param $type
     * @return mixed
     * @throws SmsException
     */
    private static function getHandle($type):Sms{
        $class_name = __NAMESPACE__ . '\\Handles\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $type)));
        if (class_exists($class_name)) {
            return new $class_name();
        }else{
            throw new SmsException($class_name. ' not exist');
        }
    }

}
