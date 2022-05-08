<?php

namespace App\Http\Controllers\Api\V1\Tencent;

use App\Http\Controllers\Controller;
use App\Http\Services\CloudTencentSms\TencentSms;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

// 腾讯云短信管理
class SmsController extends Controller
{
    //发送短信
    /**
     * @OA\Post (
     *     path="/api/v1/tencent/sendSms",
     *     tags={"短信管理",},
     *     summary="发送腾讯云短信",
     *     description="用于注册/登陆/修改密码(2022/05/31已完成)",
     *     @OA\Parameter(name="tel", in="query", @OA\Schema(type="string"),description="用于接收短信的手机号 必须"),
     *     @OA\Parameter(name="type", in="query", @OA\Schema(type="string"),description="register/reset 必传 二选一"),
     *     @OA\Response(
     *         response=200,
     *         description="{code: 200, msg:string, data:[]}",
     *     ),
     *    )
     */
    function sendSms(Request $request): array
    {
        if (!isset($request->type)) {
            return $this->backArr("type必须", config("comm_code.code.fail"), []);
        }
        if (in_array($request->type, ["register", "reset"])) {
            return $this->backArr("type必须", config("comm_code.code.fail"), []);
        }
        if (!isset($request->tel)) {
            return $this->backArr("手机号必须", config("comm_code.code.fail"), []);
        }
        if (!$this->checkPhone($request->tel)) {
            return $this->backArr("手机号格式错误", config("comm_code.code.fail"), []);
        }
        $code = mt_rand(000000, 999999);
        $rs = TencentSms::sendSms($request->tel, $code, 10, $request->type);
        if ($rs["code"] == 1) {
            //新增缓存 10分钟有效
            $redisRs = Redis::setex($this->telCodeRule($request->tel), 10 * 60, $code);
            if ($redisRs) {
                return $this->backArr("验证码发送成功！", config("comm_code.code.ok"), []);
            }
            return $this->backArr("验证码缓存失败！", config("comm_code.code.fail"), []);
        }
        return $this->backArr($rs["msg"], config("comm_code.code.fail"), []);

    }
}
