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
