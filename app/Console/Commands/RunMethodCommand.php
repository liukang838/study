<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunMethodCommand extends Command
{
    protected $signature = 'run:method {--method=} {--m=} {--params=} {--p=} {--e} {--echo}';

    protected $description = 'check data.
    ex: 
    php artisan check:data --method="\App\Zrisk\Pay\PayBalanceRisk::checkPayDataByUserId" --p=1000012';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $method = $this->option('method');
        $method = !empty($method) ? $method : $this->option('m');
        $params = $this->option('params');
        $params = !empty($params) ? $params : $this->option('p');
        $isEcho = $this->option('echo');
        $isEcho = !empty($isEcho) ? $isEcho : $this->option('e');

        if (empty($method)) {
            $this->line('method can`t be empty.');
            exit;
        }
        try {
            $method = explode('::', $method);
            $class = $method[0];
            $method = $method[1];
            $params = empty($params) ? [] : explode(',', $params);
            $class = new \ReflectionClass($class);
            //命令运行时强制主库
//            db_force_master();
            $instance = $class->newInstance();
            $ret = $instance->$method(...$params);
            if ($isEcho && $ret) (is_array($ret) || is_object($ret)) ? $this->line(json_encode($ret, JSON_UNESCAPED_UNICODE)) : $this->line($ret);
        } catch (\Exception $e) {
            $this->line($e->getMessage() . ' ' . $e->getTraceAsString());
        }
    }
}
