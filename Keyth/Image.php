<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 12/6/18
 * Time: 9:19 PM
 */

namespace Keyth;

class Image
{
    private $width;
    private $height;
    private $im;
    private $bg;
    private $m;
    private $type=array('num' => 9,'letter' => 61 );
    function __construct($width,$height,$m)
    {
        $this->width=$width;
        $this->height=$height;
        $this->m=$m;
        $this->im=imagecreatetruecolor($this->width, $this->height);
        $this->bg=imagecolorallocate($this->im, 220, 220, 220);}
    private function getCode(){
        $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFIGHIJKLMNOPQRSTUVWXVZ";
        $t='';
        for($i=0;$i<$this->m;$i++){
            $t.=$str[rand(0,$this->type['letter'])];}
        $_SESSION[$_COOKIE['PHPSESSID']]=$t;
        return $t;}

    function drawCode(){
        $code=$this->getCode();//获取验证码字符串
        imagefill($this->im, 0, 0, $this->bg);
        for ($i=0; $i <400 ; $i++) {
            imagesetpixel($this->im, rand(0,$this->width), rand(0,$this->height), rand(0,255));}
        imageline($this->im, rand(0,$this->width), rand(0,$this->height), rand(0,$this->width), rand(0,$this->height), rand(0,255));
        $c=imagecolorallocate($this->im, rand(0,200), rand(0,200), rand(0,200));
        if($this->m==4){
            $x=22;}
        else{
            $x=19;}
        for($i=0;$i<$this->m;$i++){
            imagettftext($this->im, 26, rand(-30,30), $x+($x*$i), 25, $c, "Public/gordon__.ttf",$code[$i] );}}

    function printImage(){
        $this->drawCode();
        header('Content-type:image/png');
        imagepng($this->im);}

}


