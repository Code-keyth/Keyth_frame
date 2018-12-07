<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 11/30/18
 * Time: 5:32 PM
 */
namespace App\Controllers\Index;
use App\Controller;

use Keyth\Request;
use Keyth\View;

class Index extends Controller
{
    public function index(){
        $yzm=Request::instance()->post('captcha');
        return View::render('Index/index');
    }

}


