<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 12/3/18
 * Time: 5:56 PM
 */

function dump($var)
{
    if (is_bool($var)) {
        var_dump($var);
    } else if (is_null($var)) {
        var_dump($var);
    } else {
        echo "<pre style='background-color: gainsboro;padding: 5px;border:2px solid red;max-width:1000px;margin: 5px auto;border-radius:25px;'>".print_r($var,true)."</pre>";
    }
}

function Debug($info, $Reason = '')
{
    $debug = Config::$debug;
    if ($debug) {
        die("<pre style=' color: lavenderblush; ;background-color: brown;padding:10px;border:2px solid red;max-width:1000px;margin: 5px auto;'><h1>[Error!!!]</h1> <b>".print_r($info, true)."</b></n></pre><pre style='color:orangered ;background-color: orange;padding:10px;border:2px solid red;max-width:1000px;margin: 5px auto;'>".print_r($Reason, true) . "</pre>");
    }else{
        echo "程序运行错误！！";}

}