<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 12/1/18
 * Time: 4:09 PM
 */

class Config{
    //数据库信息
    static $db_info=[
        "host"=>'127.0.0.1',
        "name"=>'xl',
        "user"=>"keyth",
        "pwd"=>"YC19980321..",
        "prefix"=>'',
    ];

    //twig 是否开启框架DEBUG
    static $debug=true;

    static $upload=[
        //默认文件上传路径
        "path"=>'/Public/Upload',
        //开启上传文件 以时间分类
        "path_date"=>True,
        //是否开启文件名自定义
        "name"=>True,
    ];
    static $view=[
        //默认缓存文件目录
        "temp"=>'/runtime/temp/',
        //twig DEBUG
        "debug"=>True,];

    static $captcha=[
        'state'=>True,
        'width'=>120,
        'height'=>30,
        'length'=>5,
        ];
    static $route=[
        //自定义url
        'captcha'=>['Http','Common','captcha'],
    ];


}