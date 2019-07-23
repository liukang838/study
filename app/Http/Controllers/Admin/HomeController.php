<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/7/4
 * Time: 上午11:52
 */
class HomeController extends Controller
{
    public function index(Content $content)
    {
        // 选填
        $content->header('填写页面头标题');

        // 选填
        $content->description('填写页面描述小标题');

        // 添加面包屑导航 since v1.5.7
        $content->breadcrumb(
            ['text' => '首页', 'url' => '/admin'],
            ['text' => '用户管理', 'url' => '/admin/users'],
            ['text' => '编辑用户']
        );

        // 填充页面body部分，这里可以填入任何可被渲染的对象
        $content->body('hello world');

        // 在body中添加另一段内容
        $content->body('foo bar');

        // `row`是`body`方法的别名
        $content->row('hello world');

        // 直接渲染视图输出，Since v1.6.12
        $content->view('dashboard', ['data' => 'foo']);

        return $content;
    }
}
