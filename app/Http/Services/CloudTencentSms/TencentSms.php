<?php

namespace App\Http\Services\CloudTencentSms;

use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Sms\V20210111\SmsClient;
use TencentCloud\Sms\V20210111\Models\SendSmsRequest;

class TencentSms
{
    /**
     * @param $tel 手机号
     * @param $code 验证码
     * @param int $expire 有效期默认10分钟
     */
    static function sendSms($tel, $code, $expireTime = 10, $type = ''): array
    {
        $secret_id = config("comm_code.tencent_vod.secret_id");
        $secret_key = config("comm_code.tencent_vod.secret_key");
        $requestSmsUrl = config("comm_code.tencent_vod.sms.sms_url");
        try {
            $cred = new Credential($secret_id, $secret_key);
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint($requestSmsUrl);

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);
            $client = new SmsClient($cred, "ap-guangzhou", $clientProfile);

            $req = new SendSmsRequest();

            if ($type === 'register') {
                $templateId = config("comm_code.tencent_vod.sms.TemplateId");

            } elseif ($type === 'reset') {
                $templateId = config("comm_code.tencent_vod.sms.TemplateIdReset");
            } else {
                $templateId = '';
            }
            $params = array(
                "PhoneNumberSet" => array($tel),
                "SmsSdkAppId" => config("comm_code.tencent_vod.sms.SmsSdkAppId"),
                "SignName" => config("comm_code.tencent_vod.sms.SignName"),
                "TemplateId" => $templateId,
                "TemplateParamSet" => array((string)$code, (string)$expireTime),//验证码 有效期
            );
            $req->fromJsonString(json_encode($params));

            $resp = $client->SendSms($req);

            // print_r($resp->toJsonString());
            return ["code" => 1, "msg" => $resp->toJsonString()];
        } catch (TencentCloudSDKException $e) {
            return ["code" => 0, "msg" => $e->getMessage()];

        }
    }
}
