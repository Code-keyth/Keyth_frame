<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 12/3/18
 * Time: 7:36 PM
 */

namespace Keyth;
use Config;
class View
{
    public $view;
    public $data;
    public $twig;
    public $path = APP. '/Views/';
    /**
     * Twig constructor.
     * @param $view
     * @param $data
     */

    public function __construct($view='Index/index', $data=array())
    {
        $loader = new \Twig_Loader_Filesystem($this->path);
        $con_view=Config::$view;
        $captcha=Config::$captcha;
        $this->twig = new \Twig_Environment($loader, array(
            'cache' => BASEDIR.(empty($con_view['temp']) ? $con_view['temp'] : '/runtime/temp/'),
            'debug' => ($con_view['debug'] ? $con_view['debug']:False ),)
        );
        $this->view = $view;
        $this->data = $data;
        $this->data['captcha']=($captcha['state'] ? '<img src="/captcha" onclick="this.src=\'/captcha\';">':' ');
    }

    /**
     * @param $view
     * @param array $data
     * @return View
     */
    public static function render($view, $data = array())
    {
        return new View($view,$data);}

    public function __destruct()
    {
        $this->twig->display($this->view.'.html', $this->data);}
}