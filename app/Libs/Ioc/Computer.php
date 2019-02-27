<?php

namespace App\Libs\Ioc;


/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/2/27
 * Time: 下午3:11
 */
class Computer
{
    protected $keyboard;

    public function __construct(Keyboard $keyboard)
    {
        $this->keyboard = $keyboard;
    }
}

interface Keyboard
{
    public function brand();
}

class CommonBoard implements Keyboard
{
    public function brand()
    {
        // TODO: Implement brand() method.
        return 'Common';
    }
}

class LuojiBoard implements Keyboard
{
    public function brand()
    {
        // TODO: Implement brand() method.
        echo 'Luoji';
    }
}

class Container
{
    protected $binds;

    protected $instances;

    public function bind($abstract, $concrete)
    {
        if ($concrete instanceof \Closure) {
            $this->binds[$abstract] = $concrete;
        } else {
            $this->instances[$abstract] = $concrete;
        }
    }

    public function make($abstract, $parameters = [])
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        return call_user_func($this->binds[$abstract], $parameters);
    }

}

$container = new Container();

$container->bind('Keyboard', function () {
    return new CommonBoard();
});

$keyboard = $container->make('Keyboard');

$container->bind('Computer', function ($keyboard) {
    return new Computer($keyboard);
});

var_dump($container->make('Computer', $keyboard));


