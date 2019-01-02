<?php
/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2018/12/3
 * Time: 下午5:58
 */

(new process())->run();

class process
{
    public $mpid = 0;

    public $works = [];

    public $max_precess = 100;

    public $new_index = 0;

    public function __construct()
    {
        try {
            //设置主进程的名称
            swoole_set_process_name(sprintf('php-ps:%s', 'master'));
            $this->mpid = posix_getpid();

            $this->run();
            $this->processwait();

        } catch (\Exception $e) {
            die('ALL ERROR:' . $e->getMessage());
        }
    }

    /**
     * 开始执行
     */
    public function run()
    {
        for ($i = 0; $i < $this->max_precess; $i++) {
            $this->createProcess();
        }
    }

    /**
     * 创建进程
     *
     * @param null $index
     */
    public function createProcess($index = null)
    {
        $process = new swoole_process(function (swoole_process $worker) use ($index) {
            if (is_null($index)) {
                $index = $this->new_index;

                $this->new_index++;
            }

            swoole_set_process_name(sprintf('php-ps:%s', $index));

            for ($j = 0; $j < 1000; $j++) {
                $this->checkMpid($worker);
                echo "msg: {$j}\n";
                sleep(1);
            }

        }, false, false);

        $pid = $process->start();
        $this->works[$index] = $pid;
    }

    /**
     * 检测主进程的进程ID
     *
     * @param $worker
     */
    public function checkMpid(& $worker)
    {
        if (!swoole_process::kill($this->mpid, 0)) {
            $worker->exit();
            // 这句提示,实际是看不到的.需要写到日志中
            echo "Master process exited, I [{$worker['pid']}] also quit\n";
        }
    }

    /**
     * 子进程异常退出时，自动重启
     *
     * @param $ret
     * @throws Exception
     */
    public function rebootProcess($ret)
    {
        $pid = $ret['pid'];
        $index = array_search($pid, $this->works);
        if ($index !== false) {
            $index = intval($index);
            $new_pid = $this->CreateProcess($index);
            echo "rebootProcess: {$index}={$new_pid} Done\n";
            return;
        }
        throw new \Exception('rebootProcess Error: no pid');
    }

    /**
     * 主进程异常退出时，子进程会继续执行，完成所有任务后退出
     *
     * @throws Exception
     */
    public function processWait()
    {
        while (true) {
            if (count($this->works)) {
                $ret = swoole_process::wait();
                if ($ret) {
                    $this->rebootProcess($ret);
                }
            } else {
                break;
            }
        }
    }

}