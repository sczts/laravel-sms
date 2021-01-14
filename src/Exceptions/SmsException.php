<?php


namespace Sczts\Sms\Exceptions;


class SmsException extends \Exception
{
    public function __construct($message = "", $code = 0) {
        $this->message = $message;
        $this->code = $code;
    }
}