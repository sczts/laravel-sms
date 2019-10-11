<?php

namespace Sczts\Sms;

interface Sms
{
    public function send($phone,$content);
}