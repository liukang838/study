<?php

if (!function_exists('code_return')) {
    function code_return($statusCode, $data = null, $info = '')
    {
        if (!isset($statusCode[0]) || !isset($statusCode[1])) {
            throw new \Exception('Unknow status code!');
        }

        $result = ['code' => $statusCode[0], 'msg' => $statusCode[1], 'info' => $info, 'data' => $data];

        return $result;
    }
}

if (!function_exists('json_return')) {
    function mq_success($message = '不重发了')
    {

        $data['status'] = 'success';
        $data['result'] = $message;
        return $data;
    }

    function mq_fail($message = '我会重新发')
    {

        $data['status'] = 'fail';
        $data['result'] = $message;
        return $data;
    }

    function mq_error($message = '不重发了')
    {

        $data['status'] = 'error';
        $data['result'] = $message;
        return $data;
    }
}

if (!function_exists('mq_input')) {
    function mq_input()
    {
        if (!request()->input()) {
            return false;
        }
        return json_decode(array_keys(request()->input())[0], true)['body'];
    }
}

if (!function_exists('throw_error_code_exception')) {
    function throw_error_code_exception($statusCode, $data = null, $info = '')
    {
        throw new \App\Exceptions\ErrorCodeException($statusCode, $data, $info);
    }
}

if (!function_exists('format_exception_log')) {

    function format_exception_log(\Exception $e)
    {
        return $e->getCode() . '>>' . $e->getFile() . '>>' . $e->getLine() . '>>' . $e->getMessage() . '>>' . $e->getTraceAsString();
    }
}

if (!function_exists('generate_sign')) {
    function get_sort_params_string($params, $appSecret)
    {
        unset($params['sign']);
        ksort($params);
        return $appSecret . multi_array_to_string($params) . $appSecret;
    }

    function multi_array_to_string($array)
    {
        $result_array = '';
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                multi_array_to_string($value);
            } else
                $result_array .= $key . $value;
        }
        return $result_array;
    }

    function generate_md5_sign($params, $appSecret)
    {
        return strtoupper(md5(get_sort_params_string($params, $appSecret)));
    }

    function generate_sign($params, $appSecret, $sigMethod)
    {
        if (mb_strtoupper($sigMethod) == 'MD5')
            return generate_md5_sign($params, $appSecret);
        return false;
    }

}

if (!function_exists('mosaic_email')) {
    function mosaic_email($email)
    {
        if (is_null($email) || empty($email)) return $email;
        $email_array = explode("@", $email);
        $prevFix = (strlen($email_array[0]) < 4) ? substr($email, 0, strlen($email_array[0]) - 1) : substr($email, 0, 3);
        $result = $prevFix . str_repeat("*", 3) . '@' . $email_array[1];
        return $result;
    }
}

if (!function_exists('mosaic_number')) {
    function mosaic_number($str)
    {
        if (is_null($str) || empty($str)) return $str;
        $pattern = '/(1[0-9]{1}[0-9])[0-9]{4}([0-9]{4})/i';
        if (preg_match($pattern, $str)) {
            $rs = preg_replace($pattern, '$1****$2', $str); // substr_replace($name,'****',3,4);
        } else {
            $rs = substr($str, 0, 3) . "***" . substr($str, -1);
        }
        return $rs;
    }
}

if (!function_exists('mosaic_str')) {
    function mosaic_str($str)
    {
        if (!isset($str) || empty($str)) return '***';
        if (strlen($str) <= 2) return $str . '***';
        return mb_substr($str, 0, 1) . str_repeat("*", 3) . mb_substr($str, -1);
    }
}

if (!function_exists('mosaic_name')) {
    function mosaic_name($str)
    {
        $strLen = mb_strlen($str);
        $newStrArr = [];
        for ($i = 0; $i < $strLen; $i++) {
            $newStrArr[$i] = $i % 2 != 0 ? '*' : mb_substr($str, $i, 1);
        }
        return implode('', $newStrArr);
    }
}

if (!function_exists('constants_in_class')) {
    function constants_in_class($class)
    {
        $reflectionClass = new \ReflectionClass($class);
        $constants = $reflectionClass->getConstants();
        return $constants;
    }
}

if (!function_exists('get_server_ip')) {
    function get_server_ip()
    {
        if (isset($_SERVER['SERVER_ADDR'])) {
            $server_ip = $_SERVER['SERVER_ADDR'];
        } else if (isset($_SERVER['LOCAL_ADDR'])) {
            $server_ip = $_SERVER['LOCAL_ADDR'];
        } else {
            $server_ip = $_SERVER['HOSTNAME'];
        }
        return $server_ip;
    }
}

if (!function_exists('bcadd')) {
    function bcadd($a, $b, $scale = 2)
    {
        return number_format($a + $b, $scale, '.', '');
    }
}

if (!function_exists('bccomp')) {
    function bccomp($a, $b, $scale = 2)
    {
        $a = number_format($a, $scale, '.', '');
        $b = number_format($b, $scale, '.', '');
        if ($a == $b) return 0;
        return $a - $b > 0 ? 1 : -1;
    }
}

if (!function_exists('bcmul')) {
    function bcmul($a, $b, $scale = 2)
    {
        return number_format($a * $b, $scale, '.', '');

    }
}

if (!function_exists('bcsub')) {
    function bcsub($a, $b, $scale = 2)
    {
        return number_format($a - $b, $scale, '.', '');

    }
}

if (!function_exists('cache_array')) {
    function cache_array($key, $value)
    {
        $array = \Cache::get($key, []);
        $array[] = $value;
        return \Cache::forever('expect_goods', $array);
    }
}

if (!function_exists('redis_rpush')) {
    function redis_rpush($key, $value)
    {
        return \Cache::getRedis()->connection()->rpush(env('REDIS_PREFIX') . ':' . $key, $value);
    }
}

if (!function_exists('redis_lpop')) {
    function redis_lpop($key)
    {
        return \Cache::getRedis()->connection()->lpop(env('REDIS_PREFIX') . ':' . $key);
    }
}


if (!function_exists('set_key_from_array')) {

    /**
     * 将数组以｛keyName｝为key的值做数组key返回
     *
     * $arr = array(array('a'=>1,'b'=>2),array('a'=>3,'b'=>4))
     * setKeyFromArray($arr, 'a');
     * =>  array( 1 => array('a'=>1,'b'=>2), 3 => array('a'=>3,'b'=>4))
     *
     * @param $arr
     * @param $keyName
     *
     * @return array
     */
    function set_key_from_array($arr, $keyName, $isItemObject = false)
    {
        $res = array();
        foreach ($arr as $item) {
            if ($isItemObject) $item = json_decode(json_encode($item), true);
            if (isset($item[$keyName])) {
                $res[$item[$keyName]] = $item;
            }
        }
        return $res;
    }
}

if (!function_exists('set_key_from_multi_array')) {
    function set_key_from_multi_array($arr, $keyName)
    {
        $res = array();
        foreach ($arr as $item) {
            if (isset($item[$keyName])) {
                $res[$item[$keyName]][] = $item;
            }
        }
        return $res;
    }
}

if (!function_exists('set_key_from_object')) {

    function set_key_from_object($arr, $keyName)
    {
        $res = array();
        foreach ($arr as $item) {
            if (isset($item->$keyName)) {
                $res[$item->$keyName] = $item;
            }
        }
        return $res;
    }
}

if (!function_exists('object2array')) {

    function object2array(&$object)
    {
        $object = json_decode(json_encode($object), true);
        return $object;
    }
}

/**
 * 获取某一周的开始日期和结束日期
 */
if (!function_exists('getWeekRange')) {
    function getWeekRange($date, $start = 0)
    {
        $sdefaultDate = $date;

        //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $first = $start;

        //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $w = date('w', strtotime($sdefaultDate));

        //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $week_start = date('Ymd', strtotime("$sdefaultDate -" . ($w ? $w - $first : 6) . ' days'));

        //本周结束日期
        $week_end = date('Ymd', strtotime("$week_start +6 days"));
        return array($week_start, $week_end);
    }
}

if (!function_exists('getMonthWeeks')) {
    function getMonthWeeks($current_month, $current_year = '2017')
    {
        $firstDay = strtotime($current_year . '-' . $current_month . '-01');

        //计算本月头一天的星期一
        $monDay = $firstDay - 86400 * (date('N', $firstDay) - 1);//计算第一个周一的日期
        //由于每个月只有四周 让 $i 从 1 到 5 增加即可
        $dataArr = [];
        for ($i = 1; $i <= 5; $i++) {
            $startDate = date("Y-m-d", $monDay + ($i - 1) * 86400 * 7);//起始周一
            $endDate = date("Y-m-d", $monDay + $i * 86399 * 7);//结束周日
            if (date('m', $monDay + $i * 86399 * 7) != $current_month) {
                continue;
            }
            $dataArr[] = [$startDate, $endDate];
        }
        return $dataArr;
    }
}

/**
 * 生成从开始月份到结束月份的月份数组
 * @param int $start 开始时间戳
 * @param int $end 结束时间戳
 */
if (!function_exists('monthList')) {
    function monthList($start, $end)
    {
        if (!is_numeric($start) || !is_numeric($end) || ($end <= $start)) return '';
        $start = date('Y-m', $start);
        $end = date('Y-m', $end);
        //转为时间戳
        $start = strtotime($start . '-01');
        $end = strtotime($end . '-01');
        $i = 0;//http://www.phpernote.com/php-function/224.html
        $d = array();
        while ($start <= $end) {
            //这里累加每个月的的总秒数 计算公式：上一月1号的时间戳秒数减去当前月的时间戳秒数
            $d[$i] = trim(date('Y-m', $start), ' ');
            $start += strtotime('+1 month', $start) - $start;
            $i++;
        }
        return $d;
    }
}

if (!function_exists('getMonthDaysUntilYesterday')) {
    function getMonthDaysUntilYesterday($month = "this month", $format = "Y-m-d", $dateTimeZone = false)
    {
        if (!$dateTimeZone) $dateTimeZone = new DateTimeZone("Asia/Shanghai");
        $start = new DateTime("first day of $month", $dateTimeZone);
        $end = new DateTime("last day of $month", $dateTimeZone);

        $yesterday = new DateTime("-1 day", $dateTimeZone);
        if ($end > $yesterday) {
            $end = $yesterday;
        }

        $days = array();
        for ($time = $start; $time <= $end; $time = $time->modify("+1 day")) {
            $days[] = $time->format($format);
        }
        return $days;
    }
}


if (!function_exists('dtRpcData')) {
    function dtRpcData($rpcData)
    {
        if (!isset($rpcData['result']) || !isset($rpcData['result']['code'])) {
            throw new Exception('Rpc Data Error!');
        }

        if ($rpcData['result']['code'] != '1001') {
            \Log::error('RPC ERROR! code: ' . $rpcData['result']['code'] . '>> msg: ' . $rpcData['result']['msg'] . ' >> ' . json_encode(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 5)));
            throw_error_code_exception([$rpcData['result']['code'], $rpcData['result']['msg']], $rpcData['result']['data'], $rpcData['result']['info']);
        }

        return $rpcData['result']['data'];
    }
}

if (!function_exists('dtRpcResult')) {
    function dtRpcResult($dtRpcResult)
    {
        if (!isset($dtRpcResult['result'])) {
            throw new Exception('Rpc Data Error!');
        }

        return $dtRpcResult['result'];

    }
}

if (!function_exists('gmt_iso8601')) {
    function gmt_iso8601($time)
    {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration . "Z";
    }
}

if (!function_exists('arraySort')) {
    function arraySort($arr, $keys, $type = 'asc')
    {
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v) {
            $keysvalue[$k] = $v[$keys];
        }
        $type == 'asc' ? asort($keysvalue) : arsort($keysvalue);
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
}

if (!function_exists('orderByName')) {
    function orderByName($array)
    {
        foreach ($array as $key => $value) {
            $new_array[$key] = iconv('UTF-8', 'GBK', $value);
        }
        asort($new_array);
        $output = [];
        foreach ($new_array as $key => $value) {
            $output[$key] = iconv('GBK', 'UTF-8', $value);
        }
        return $output;
    }
}

if (!function_exists('db_force_master')) {
    function db_force_master($dbs = [])
    {
        if (empty($dbs)) $dbs = array_keys(config('database.connections'));
        foreach ($dbs as $con) {
            \DB::connection($con)->setReadPdo(\DB::connection($con)->getPdo());
        }
    }
}

if (!function_exists('get_real_ip')) {
    function get_real_ip()
    {
        $host_ip = request()->header('x-forwarded-for', request()->ip());
        $host_ips = explode(',', $host_ip);
        return array_get($host_ips, 0, '');
    }
}

if (!function_exists('getStartAndEndDateByMonth')) {
    function getStartAndEndDateByMonth($month)
    {
        $date = date("Y-$month-01");
        $firstDay = date('Y-m-01 00:00:00', strtotime($date));
        $lastDay = date('Y-m-d 23:59:59', strtotime("$firstDay +1 month -1 day"));
        return [$firstDay, $lastDay];
    }
}

if (!function_exists('execCurl')) {
    function execCurl($url, $isPost = false, $data = '', $in = 'utf8', $out = 'utf8', $cookie = '')
    {
        $fn = curl_init();
        curl_setopt($fn, CURLOPT_URL, $url);
        curl_setopt($fn, CURLOPT_TIMEOUT, 10);
        curl_setopt($fn, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($fn, CURLOPT_REFERER, $url);
        curl_setopt($fn, CURLOPT_HEADER, 0);
        if ($cookie)
            curl_setopt($fn, CURLOPT_COOKIE, $cookie);
        if ($isPost) {
            curl_setopt($fn, CURLOPT_POST, TRUE);
            curl_setopt($fn, CURLOPT_POSTFIELDS, $data);
        }
        $fm = curl_exec($fn);
        curl_close($fn);
        if ($in != $out) {
            $fm = iconv($in, $out, $fm);
        }
        return $fm;
    }
}

if (!function_exists('sortArrByManyField')) {
    function sortArrByManyField()
    {
        $args = func_get_args();
        if (empty($args)) {
            return null;
        }
        $arr = array_shift($args);
        if (!is_array($arr)) {
            throw new Exception("第一个参数不为数组");
        }
        foreach ($args as $key => $field) {
            if (is_string($field)) {
                $temp = array();
                foreach ($arr as $index => $val) {
                    $temp[$index] = $val[$field];
                }
                $args[$key] = $temp;
            }
        }
        $args[] = &$arr;//引用值
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }
}


if (!function_exists('get_extension')) {
    function get_extension($file)
    {
        return substr($file, strrpos($file, '.') + 1);
    }
}

if (!function_exists('num_tostr')) {
    function num_tostr($num)
    {
        if (stripos($num, 'e') === false)
            return $num;
        $num = trim(preg_replace('/[=\'"]/', '', $num, 1), '"'); //出现科学计数法，还原成字符串
        $result = "";
        while ($num > 0) {
            $v = $num - floor($num / 10) * 10;
            $num = floor($num / 10);
            $result = $v . $result;
        }
        return $result;
    }
}

if (!function_exists('now_time')) {
    function now_time()
    {
        return date('Y-m-d H:i:s', time());
    }
}

if (!function_exists('url_change')) {
    function url_change($url)
    {
        return str_replace('_', '.', $url);
    }
}
if (!function_exists('getRedisLock')) {
    /**
     * 获取分布式锁
     * @param string $key 键
     * @param int $timeoutMin 超时时间，单位分钟
     * @return bool 是否成功获得锁
     */
    function getRedisLock($key, $timeoutMin = 10)
    {
        $payload = \Cache::connection()->set(\Cache::getPrefix() . $key, 1, "EX", $timeoutMin * 60, "NX");
        if (is_null($payload)) {
            Log::info('redisLock key => ' . $key . ' pid => ' . getmypid());
            return false;
        }
        return true;
    }
}

if (!function_exists('redisLock')) {

    function redisLock(callable $fun, $key, $timeoutMin = 10)
    {
        $lock = getRedisLock($key, $timeoutMin);
        if ($lock === false) return false;

        try {
            $ret = call_user_func($fun);
            \Cache::forget($key);
            return $ret;
        } catch (\Exception $e) {
            \Cache::forget($key);
            throw $e;
        }
    }
}
if (!function_exists('is_mobile')) {
    /*移动端判断*/
    function is_mobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('msec_time')) {

    function msec_time()
    {
        list($msec, $sec) = explode(' ', microtime());
        return (int)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }
}

if (!function_exists('array_value_null2empty')) {

    function array_value_null2empty($arr, $key)
    {
        if (!isset($arr[$key])) return "";
        if (is_null($arr[$key])) return "";
        return $arr[$key];
    }
}

if (!function_exists('id_decode')) {
    function id_decode($str)
    {
        $key = 'liangju';
        $length = 10;
        if (!isset($str) || empty($str)) return false;
        if (is_numeric($str)) return $str;
        $hashids = new \Hashids\Hashids($key, $length);
        $ids = $hashids->decode($str);
        if (!$ids) return false;
        $count = count($ids);
        if ($count == 1) return $ids[0];
        return $ids;
    }
}

if (!function_exists('id_encode')) {
    function id_encode($id)
    {
        $key = 'liangju';
        $length = 10;
        if (!isset($id) || empty($id)) return false;
        if (!is_numeric($id)) return false;
        $hashids = new \Hashids\Hashids($key, $length);
        $str = $hashids->encode($id);
        if (!$str) return false;
        return $str;
    }
}

if (!function_exists('is_env_production')) {
    function is_env_production()
    {
        return env('APP_ENV') === 'production';
    }
}

if (!function_exists('decryptApiSign')) {
    function decryptApiSign($serverArray, $secret)
    {
        $clientSign = $serverArray['sign'];

        unset($serverArray['sign']);

        ksort($serverArray);
        $text = '';
        foreach ($serverArray as $k => $v) {
            $text .= $k . $v;
        }

        $reServerSign = md5($secret . $text . $secret);
        return $clientSign == $reServerSign ? true : false;
    }
}

if (!function_exists('encryptApiSign')) {
    function encryptApiSign($array, $secret)
    {
        ksort($array);
        $text = '';
        foreach ($array as $k => $v) {
            $text .= $k . $v;
        }

        return md5($secret . $text . $secret);
    }
}

if (!function_exists('get_302_url')) {
    function get_302_url($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        $headers = curl_getinfo($ch);
        curl_close($ch);
        return $data != $headers ? $headers['url'] : $url;
    }
}

if (!function_exists('filterStr')) {
    function filterStr($str)
    {
        $patten = "/[\x{4e00}-\x{9fa5}a-zA-Z0-9]/u";
        preg_match_all($patten, $str, $resp);
        return isset($resp[0]) ? implode('', $resp[0]) : $str;
    }
}

if (!function_exists('filterUrl')) {
    function filterUrl($str)
    {
        $patten = "/(http|https):\/\/([\w\d\-_]+[\.\w\d\-_]+)[:\d+]?([\/]?[\w\/\.]+)/i";
        preg_match($patten, $str, $resp);
        return isset($resp[0]) ? implode('', $resp[0]) : $str;
    }
}