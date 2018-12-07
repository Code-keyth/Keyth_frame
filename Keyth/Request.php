<?php

namespace Keyth;
use Config;

class Request{
    public $input='';
    static $name='';
    protected static $instance;
    protected $filter;
    protected $filetype=[];
    protected $filesize=0;
    protected $filepath='/Public/Upload';
    protected $pathdate=True;
    protected $upload_name=True;

    /**
     * @var array 资源类型
     */
    protected $mimeType = [
        'xml'   => 'application/xml,text/xml,application/x-xml',
        'json'  => 'application/json,text/x-json,application/jsonrequest,text/json',
        'js'    => 'text/javascript,application/javascript,application/x-javascript',
        'css'   => 'text/css',
        'rss'   => 'application/rss+xml',
        'yaml'  => 'application/x-yaml,text/yaml',
        'atom'  => 'application/atom+xml',
        'pdf'   => 'application/pdf',
        'text'  => 'text/plain',
        'image' => 'image/png,image/jpg,image/jpeg,image/pjpeg,image/gif,image/webp,image/*',
        'csv'   => 'text/csv',
        'html'  => 'text/html,application/xhtml+xml,*/*',
    ];

    protected function __construct($options = [])
    {
        $upload=Config::$upload;
        $this->filepath=empty($upload['path'])?'/Public/Upload':$upload['path'];
        $this->pathdate=empty($upload['path_date'])?True:$upload['path_date'];
        $this->upload_name=empty($upload['name'])?True:$upload['name'];
        foreach ($options as $name => $item) {
            if (property_exists($this, $name)) {
                $this->$name = $item;}}
        $this->input = file_get_contents('php://input');
    }

    public function __call($method, $args)
    {
        Debug('函数不存在！',new \Exception('method not exists:' . __CLASS__ . '->' . $method));
    }
    /**
     * 初始化
     * @access public
     * @param array $options 参数
     * @return \Keyth
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($options);
        }
        return self::$instance;
    }
    /**
     * @access public
     * @param array $options 参数
     * @return 
     */
    public function method(){
        return $_SERVER['REQUEST_METHOD'];
    }
    /**
     * 是否为GET请求
     * @access public
     * @return bool
     */
    public function isGet()
    {
        return $this->method() == 'GET';
    }

    /**
     * 是否为POST请求
     * @access public
     * @return bool
     */
    public function isPost()
    {
        return $this->method() == 'POST';
    }

    /**
     * 是否为PUT请求
     * @access public
     * @return bool
     */
    public function isPut()
    {
        return $this->method() == 'PUT';
    }

    /**
     * 是否为DELTE请求
     * @access public
     * @return bool
     */
    public function isDelete()
    {
        return $this->method() == 'DELETE';
    }

    /**
     * 是否为HEAD请求
     * @access public
     * @return bool
     */
    public function isHead()
    {
        return $this->method() == 'HEAD';
    }
    /**
     * 是否为PATCH请求
     * @access public
     * @return bool
     */
    public function isPatch()
    {
        return $this->method() == 'PATCH';
    }

    /**
     * 当前请求 HTTP_CONTENT_TYPE
     * @access public
     * @return string
     */
    public function contentType()
    {
        $contentType = $this->server('CONTENT_TYPE');
        if ($contentType) {
            if (strpos($contentType, ';')) {
                list($type) = explode(';', $contentType);}
            else {
                $type = $contentType;}
            return trim($type);}
        return '';
    }


    /**
     * 设置获取GET参数
     * @access public
     * @param string|array  $name 变量名

     * @return mixed
     */
    public function get($name = '')
    {
        if (empty($this->get)) {
            $this->get = $_GET;}
        if (is_array($name)) {
            $this->param      = [];
            return $this->get = array_merge($this->get, $name);}
        return $this->input($this->get, $name);
    }

    /**
     * 设置获取POST参数
     * @access public
     * @param string        $name 变量名

     * @return mixed
     */
    public function post($name = '')
    {
        if (empty($this->post)) {
            $content = $this->input;
            if (empty($_POST) && false !== strpos($this->contentType(), 'application/json')) {
                $this->post = (array) json_decode($content, true);}
            else {
                $this->post = $_POST;}}
        if (is_array($name)) {
            $this->param       = [];
            return $this->post = array_merge($this->post, $name);}
        return $this->input($this->post, $name);
    }

    /**
     * 获取变量 支持过滤和默认值
     * @param array         $data 数据源
     * @param string|false  $name 字段名
     * @param mixed         $default 默认值
     * @param string|array  $filter 过滤函数
     * @return mixed
     */
    public function input($data = [], $name = '', $default = null)
    {
        if (false === $name) {
            return $data;}
        $name = (string) $name;
        if ('' != $name) {
            // 解析name
            if (strpos($name, '/')) {
                list($name, $type) = explode('/', $name);}
            // 按.拆分成多维数组进行判断
            foreach (explode('.', $name) as $val) {
                if (isset($data[$val])) {
                    $data = $data[$val];}
                else {
                    // 无输入数据，返回默认值
                    return $default;}}
            if (is_object($data)) {
                return $data;}}
        return $data;
    }
    /**
     * 获取server参数
     * @access public
     * @param string|array  $name 数据名称
     * @param string        $default 默认值
     * @param string|array  $filter 过滤方法
     * @return mixed
     */
    public function server($name = '', $default = null, $filter = '')
    {
        if (empty($this->server)) {
            $this->server = $_SERVER;}
        if (is_array($name)) {
            return $this->server = array_merge($this->server, $name);}
        return $this->input($this->server, false === $name ? false : strtoupper($name), $default, $filter);
    }

    /**
     * 获取文件信息
     *
    **/
    public function file($name,$new_name=''){
        if(empty($_FILES[$name])){
            return false;}
        if ($_FILES[$name]["error"] > 0) {
            echo "Error: " . $_FILES[$name]["error"] . "<br />";}
        else {
            if(!empty($this->filetype)){
                if(!in_array($_FILES[$name]["type"],$this->filetype)){
                    return "不允许上传的文件类型！允许的类型有：".implode(',',$this->filetype);}}
            if(!empty($this->filesize)){
                if(($_FILES[$name]["size"]>$this->filesize)){
                    return '超过限制的文件大小！不允许超过'.($this->filesize/1024).'KB！';}}
            if($this->pathdate){
                $this->filepath.='/'.date('Y').'/'.date('m');}
            if(!is_dir(BASEDIR.$this->filepath)){
                mkdir(BASEDIR.$this->filepath,0777,true);}
            $hz_Arr=explode('.',$_FILES[$name]["name"]);
            if(empty($new_name)){
                $new_name=date('Ymdhis',time()).substr(md5(time()),4,30);}
            if(count($hz_Arr)>1){
                $new_name.='.'.array_pop($hz_Arr);}
            $path_name=$this->filepath .'/'.$new_name;
            move_uploaded_file($_FILES[$name]["tmp_name"],BASEDIR.$path_name);
        return $path_name;}
    }

    /**
     * 自定义文件路径,路径不存在自动创建！
     **/
    public function filepath($path,$datepath=True){
        if($datepath){
            $path.='/'.date('Y').'/'.date('m');}
        if(!is_dir($path)){
            mkdir(BASEDIR.$path,0777,true);
            $this->filepath=$path;}
        return $this;
    }


    /**
     * 允许的文件类型与大小
     *
     **/
    public function filetype($type=array(),$size=0){
        $alltype=[
            "gif"=>"image/gif", "jpg"=>"image/jpeg", "png"=>"image/png", "bmp"=>"image/bmp", "psd"=>"application/octet-stream", "ico"=>"image/x-icon",
            "rar"=>"application/octet-stream", "zip"=>"application/zip", "7z"=>"application/octet-stream", "exe"=>"application/octet-stream",
            "avi"=>"video/avi", "rmvb"=>"application/vnd.rn-realmedia-vbr", "3gp"=>"application/octet-stream", "flv"=>"application/octet-stream",
            "mp3"=>"audio/mpeg", "wav"=>"audio/wav", "krc"=>"application/octet-stream", "lrc"=>"application/octet-stream", "txt"=>"text/plain",
            "doc"=>"application/msword", "xls"=>"application/vnd.ms-excel", "ppt"=>"application/vnd.ms-powerpoint", "pdf"=>"application/pdf",
            "chm"=>"application/octet-stream", "mdb"=>"application/msaccess", "sql"=>"application/octet-stream", "con"=>"application/octet-stream",
            "log"=>"text/plain", "dat"=>"application/octet-stream", "ini"=>"application/octet-stream", "php"=>"application/octet-stream", "html"=>"text/html",
            "htm"=>"text/html", "ttf"=>"application/octet-stream", "fon"=>"application/octet-stream", "js"=>"application/x-javascript", "xml"=>"text/xml",
            "dll"=>"application/octet-stream",];
        foreach ($type as $item){
            if(array_key_exists($item,$alltype)){
                $this->filetype[]= $alltype[$item];}}
        $this->filesize = $size * 1024;
        return $this;
    }
    static function getCookies($name=''){
        if (!empty($name)){
            if(!empty($_COOKIE[$name])){
                return $_COOKIE[$name];
            }
            return null;
        }
        return $_COOKIE;
    }
    static function captcha($val=''){
        if(strtolower($_SESSION[$_COOKIE['PHPSESSID']])===strtolower($val)){
            return True;
        }else{
            return FALSE;
        }
    }
}


