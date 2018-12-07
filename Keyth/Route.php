<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 12/1/18
 * Time: 3:55 PM
 */

namespace Keyth;
use Config;

class Route
{
    public $model='Index';
    public $contr='Index';
    public $action='index';
    public function __construct(){
        $path=$_SERVER['REQUEST_URI'];
        $action_get=explode('?',$path);
        $route=Config::$route;
        if(count($action_get)==1){
            $paths=explode('/',$path);
            array_shift($paths);
            $paths_numb=count($paths);
            if(empty($paths[$paths_numb-1])){
                unset($paths[$paths_numb-1]);}
        }else{
            $paths=explode('/',$action_get[0]);
            array_shift($paths);
            $paths_numb=count($paths);
            if(empty($paths[$paths_numb-1])){
                unset($paths[$paths_numb-1]);}}

        if(!empty($paths[0])){
            $this->model=ucfirst($paths[0]);
            if(array_key_exists($paths[0],$route)){
                $this->model=$route[$paths[0]][0];
                $this->contr=$route[$paths[0]][1];
                $this->action=$route[$paths[0]][2];
                return 0;}}

        if(!empty($paths[1])){
            $this->contr=ucfirst($paths[1]);}

        if(!empty($paths[2])){
            $action_get=explode('?',$paths[2]);
            $this->action=$action_get[0];}
    }
}