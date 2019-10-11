<?php

namespace Sczts\Sms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Sms
 * @package Sczts\Sms
 * @see Sczts\Sms\SmsService
 * @method bool send($phone,$content);
 * @method bool sendTemplate($phone,$type,$data = []);
 * @method bool checkCaptcha($phone,$code,$type);
 * @method string setCaptcha($phone,$type,$length = 6);
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
