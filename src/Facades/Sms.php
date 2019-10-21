<?php

namespace Sczts\Sms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Sms
 * @package Sczts\Sms
 * @see \Sczts\Sms\SmsService::class
 * @method static bool send($phone,$content);
 * @method static bool sendTemplate($phone,$type,$data = []);
 * @method static bool checkCaptcha($phone,$code,$type);
 * @method static string setCaptcha($phone,$type,$length = 6);
 */
class Sms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sczts.sms';
    }
}
