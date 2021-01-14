<?php
return [
    'default' => env('SMS_DEFAULT','lin_kai'),
    'suffix' => env('SMS_SUFFIX',''),     // 短信统一后缀
    'handles' => [
        'lin_kai' => [  // 临凯短信
            'id' => env('SMS_LINKAI_ID',''),   // 账号
            'pwd' => env('SMS_LINKAI_PWD',''),      // 密码
            'host' => env('SMS_LINKAI_HOST','http://sdk2.028lk.com/sdk2/BatchSend2.aspx'), // 短信请求地址
        ],
        'ali' => [
            // todo 新增阿里大鱼相关配置
        ],
        'kyd' => [  // 快翼点
            'account' => env('SMS_KYD_ACCOUNT',''),
            'password' => env('SMS_KYD_PASSWORD',''),
            'host' => env('SMS_KYD_HOST','http://kyd.sr-sure.com:6889/SMSSend.aspx'),
        ]
    ],
    "templates" => [
        /**
         * {captcha} 默认为验证码占位符，不用在 $data 中指定
         * {expire} 默认为验证码过期时间占位符，不用在 $data 中指定
         * 可自定义格式为 `{name}` ，在 sendTemplate($phone,$type,$data) 里，与参数 $data 中的键值对应即可
         * @see SmsService::sendTemplate
         */
        "login" => "欢迎登录，验证码为:{captcha}，请在{expire}分钟内输入。若非本人操作，请忽略本短信，切勿将验证码泄露给他人。",
        "register" => "欢迎注册，验证码为:{captcha}，请在{expire}分钟内输入。若非本人操作，请忽略本短信，切勿将验证码泄露给他人。",
        "update_password" => "您正在进行修改密码操作当前验证码为:{captcha},请在{expire}分钟内输入。若非本人操作，请忽略本短信，切勿将验证码泄露给他人。",
    ],
    "captcha" => [
        'length' => 6,              // 验证码默认长度
        'expire' => 10,             // 验证码默认过期时间,单位(分钟)
        'prefix' => 'sms:captcha'       // 验证码缓存前缀
    ]
];
