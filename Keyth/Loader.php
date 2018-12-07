<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 11/30/18
 * Time: 5:47 PM
 */

namespace Keyth;


class Loader
{
    static function autoload($class){
        require BASEDIR.'/'.str_replace('\\','/',$class).'.php';
    }

}