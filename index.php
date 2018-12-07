<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 11/30/18
 * Time: 11:10 AM
 */

define('BASEDIR',__DIR__);
define('APP','App');
define('CONTRO','Controllers');
ini_set("display_errors", "On");
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
include BASEDIR."/Config/Config.php";
include BASEDIR.'/Keyth/Loader.php';
include APP."/function.php";
include BASEDIR.'/Keyth/run.php';


//require_once BASEDIR.'/vendor/autoload.php';
//session_start();
//spl_autoload_register('\\Keyth\\Loader::autoload');
//
//$route=new \Keyth\Route();
//$model=$route->model;
//$contr=$route->contr;
//$action=$route->action;
//$model_path=BASEDIR.'/'.APP.'/'.CONTRO.'/'.$model;
//
//if (!is_dir($model_path)){
//    dump($model."模块不存在！");
//    die();}
//
//if (!is_file($model_path.'/'.$contr.'.php')){
//    dump($contr."控制器不存在！");
//    die();}
//$class='\\'.APP.'\\'.CONTRO.'\\'.$model.'\\'.$contr;
//$ctrl=new $class();
//if(!method_exists($ctrl,$action)){
//    dump($action."方法不存在！");
//    die();}
//if(empty($_SESSION['USER_SSESSION'])){
//    $_SESSION['USER_SSESSION']=md5(time().rand(0,10000));
//}
//
//$ctrl->$action();




