<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 12/7/18
 * Time: 10:14 AM
 */
namespace App\Controllers\Http;
use Keyth\Image;


class Common
{
    public function captcha(){
        $Captcha=\Config::$captcha;
        $Image=new Image($Captcha['width'],$Captcha['height'],$Captcha['length']);
        $Image->printImage();
    }
}