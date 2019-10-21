# 快速开始

1. 使用 composer 安装
    ```
    composer require sczts/sms
    ```

2. 发布配置文件
    ```
    php artisan vendor:publish --provider="Sczts\Sms\Providers\LaravelServiceProvider"
    ```

3. 向 `.env` 添加环境变量
    ```bash
    # 短信配置
    SMS_DEFAULT=lin_kai
    # 凌凯短信配置
    SMS_LINKAI_ID=XXXXXXX
    SMS_LINKAI_PWD=123456
    SMS_LINKAI_HOST=http://sdk2.028lk.com/sdk2/BatchSend2.aspx
    SMS_LINKAI_SUFFIX="【XXXXXX】"
    ```