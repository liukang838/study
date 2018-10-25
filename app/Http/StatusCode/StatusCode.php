<?php
/**
 * Created by PhpStorm.
 * User: tanfan
 * Date: 2016/10/14
 * Time: 16:47
 */

namespace App\Http\StatusCode;

class StatusCode
{
    const SUCCESS = [1001, '正常'];
    const FAIL = [4001, '失败'];
    const DATA_ERROR = [4002, '数据异常'];
    const TIMEOUT = [4003, '调用超时'];
    const UNKNOW = [4004, '未知错误，可能的原因：\n1.网络问题\n2.服务器超时\n3.其它原因'];
    const UN_NECESSARY_PARAMS = [4005, '缺少必要参数'];
    const SYSTEM_BUSY = [4006, '系统繁忙，请稍候重试'];
    const NO_PERMISSIONS = [4007, '您无权限操作'];
    const DATA_VALIDATE_FAIL = [4008, '数据验证失败'];
    const SHOP_ONLY_RETURN_ONCE = [1002,'该红包活动全店只允许参加一次，有多个订单的情况下只发一个红包，请知悉。'];

    const USER_UN_LOGIN = [4012, '您未登录'];

    const UNKNOWN_CODE = [4099, '未知返回码'];

    public static function getByCode($code)
    {
        if (is_array($code) && isset($code[0])) $code = $code[0];

        $reflector = new \ReflectionClass(get_called_class());
        $codes = $reflector->getConstants();

        $parentClass = $reflector->getParentClass();
        if ($parentClass) {
            $parentCodes = $reflector->getParentClass()->getConstants();
            $codes = array_merge($parentCodes, $codes);
        }
        foreach ($codes as $c) {
            if (isset($c[0]) && $code == $c[0]) return $c;
        }
        return self::UNKNOWN_CODE;
    }
}
