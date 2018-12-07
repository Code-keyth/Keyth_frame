<?php
/**
 * Created by PhpStorm.
 * User: keyth
 * Date: 11/30/18
 * Time: 6:29 PM
 */

namespace Keyth;


class Db
{
    // 查询参数
    private $conn;
    static $table = '';
    static $table_index='id';
    private $field = '*';
    private $where = '';
    private $order = '';
    private $group = '';
    private $having = '';
    private $limit = '';
    private $offset = '';


    # select * from table where id=11 and name="22" group by id order by name;
    # update table set name ="33" ,name2="44" where id = 1;

    public function __construct()
    {
        $db_info = \Config::$db_info;
        $this->conn = new \mysqli($db_info['host'], $db_info['user'], $db_info['pwd'], $db_info['name']);
        if ($this->conn->connect_error) {
            die("连接失败: " . $this->conn->connect_error);}
        $index_query=$this->conn->query('show index from '.self::$table);
        if($index_query->num_rows>0){
            $index_obj=$index_query->fetch_object();
            self::$table_index=$index_obj->Column_name;
        }
    }

    /**
     * 选中数据表
     * field string or array()
     **/
    public static function table($table)
    {
        $prefix = \Config::$db_info['prefix'];
        self::$table = $prefix . $table;
        return new Db();
    }

    /**
     * field
     * 获取那些字段
     * @return Db
     **/

    public function field($filed = '')
    {
        if(is_array($filed)){
            $this->field='';
            $filed_len=count($filed);
            $hz=',';
            foreach ($filed as $item){
                if($filed_len-- == 1){
                    $hz='';}
                $this->field .= $item.$hz;}
        }else{
            $this->field = $filed;
        }
        return $this;
    }

    /**
     * where
     * @return Db
     **/
    public function where($field, $value, $op = '=')
    {
        $field = self::sql_preg($field);
        $value = self::sql_preg($value,'like');
        if (!is_numeric($value)) {
            $qz = "'";
        } else {
            $qz = '';}
        if (!empty($this->where)) {
            $this->where .= ' AND ' . $field .' '. $op .' '. $qz . $value . $qz ;
        } else {
            $this->where .= 'WHERE ' . $field .' '. $op .' '. $qz . $value . $qz;}
        return $this;
    }

    /**
     * where IN
     * @return Db
     **/
    public function whereIn($field, $value = array())
    {
        $field = self::sql_preg($field);
        if (!empty($this->where)) {
            $this->where .= ' AND ' . $field . ' in ("' . implode('","', $value) . '")';
        } else {
            $this->where .= ' WHERE ' . $field . ' in ("' . implode('","', $value) . '")';}
        return $this;
    }

    /**
     * where OR
     * @return Db
     **/
    public function whereOr($field, $value, $op = '=')
    {
        $field = self::sql_preg($field);
        $value = self::sql_preg($value);
        if (!is_numeric($value)) {
            $qz = '"';}
        else {
            $qz = '';}
        if (!empty($this->where)) {
            $this->where .= ' OR ' . $field . $op . $qz . $value . $qz;
        } else {
            $this->where .= ' WHERE ' . $field . $op . $qz . $value . $qz;}
        return $this;
    }

    public function order($field, $order = 'DESC')
    {
        if (empty($this->order)) {
            $this->order = 'ORDER BY ' . $field . ' ' . $order;
        } else {
            $this->order .= ' ,' . $field . ' ' . $order;}
        return $this;
    }

    public function group($field)
    {
        $this->group = 'GROUP BY '.$field.' ';
        return $this;
    }

    public function having($field, $value, $op = '=')
    {
        $this->having = 'HAVING ' . $field . $op . $value;
        return $this;
    }

    /**
     * limit
     **/
    public function limit($number = 15)
    {
        $this->limit = 'LIMIT ' . $number;
        return $this;
    }

    /**
     * offset
     *
     **/
    public function offset($number = 0)
    {
        $this->offset = ' OFFSET ' . $number.' ';
        return $this;
    }

    public function page($number)
    {
        $this->limit($number);
        if (!empty($_GET['page'])) {
            $this->offset($_GET['page'] - 1);
        } else {
            $this->offset();
        }
        return $this;
    }

    public function get()
    {
        $data = array();
        if (empty(self::$table)) {
            Debug('没有选择表', 'table');
            return $data;}
        $sql = 'SELECT '.$this->field .' FROM `'.self::$table.'` '.$this->where.$this->limit.$this->offset.$this->group.$this->order.';';
        $querys = $this->conn->query($sql);
        dump(addslashes($sql));
        if ($querys) {
            while ($stdclass = $querys->fetch_object()) {
                $data[] = $stdclass;}
        } else {
            Debug(mysqli_error($this->conn), $sql);
        }
        return $data;
    }

    public function first()
    {
        if (empty(self::$table)) {
            Debug('没有选择表', 'table');
            return 0;
        }
        $sql = 'SELECT ' . $this->field . ' FROM `' . self::$table . '` ' . $this->where . ' ' . $this->group . ' ' . $this->order . ';';
        $querys = $this->conn->query($sql);
        if ($querys) {
            $obj = $querys->fetch_object();
        } else {
            Debug(mysqli_error($this->conn), $sql);
        }
        return $obj;
    }

    /**
     *  sql_preg
     * 负责正则替换，过滤sql，预防sql注入！
     * @return $str
    **/
    static function sql_preg($str,$like='')
    {
        if(empty($like)){
            $str = str_replace(array('insert','select','delete','update','and','exec','count','*','%','chr','mid','master','truncate','char','declare',';','or','+','=',' '), '', $str);
        }else{
            $str = str_replace(array('insert','select','delete','update','and','exec','count','*','chr','mid','master','truncate','char','declare',';','or','+','='), '', $str);}
        return $str;
    }

    /**
     * 插入数据，返回新增数据的主键
     * @return int
     * INSERT INOT `TABLE` (`A`,`B`,`C`,`D`) VALUES(?,?,?,?);
    **/

    public function insert($data=array()){

        $sql= 'INSERT INTO `'.self::$table.'` (';
        $field='';
        $val='';
        $hz=',';
        $data_len=count($data);
        foreach ($data as $key=>$value){
            if($data_len-- == 1){
                $hz='';}
            $field.='`'.self::sql_preg($key).'`'.$hz;
            if(is_numeric($value)){
                $val.=$value.$hz;
            }else{
                $val.='"'.self::sql_preg($value).'"'.$hz;}
        }
        $sql.=$field.') VALUES ('.$val.');';
        if ($this->conn->query($sql) === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            Debug($this->conn->error,$sql) ;
        }
    }
    /**
     * 批量插入数据，返回新增数据的 id
     * @return array
     **/
    public function inserts($data=array()){
        $this->conn->autocommit(false);
        $ins_ids=[];
        foreach ($data as $item){
            $ins_ids[]=$this->insert($item);}
        if(!$this->conn->errno){
            $this->conn->commit();}
        else{
            $this->conn->rollback();}
        return $ins_ids;

    }

    /**
     * 依靠where 批量更新数据，返回更新成功的条数
     * @return int
     * $data["field"=>value1,"field3"=>value2]
     * UPDATE `xl`.`Course` SET `cname` = '离散数学', `tno` = 1 WHERE `cno` = 6;
     **/
    public function update($data=array()){
        $douh=',';
        $sql='UPDATE `'.self::$table.'` SET ';
        $data_len=count($data);
        foreach ( $data as $key=>$value){
            $value=self::sql_preg($value);
            $key=self::sql_preg($key);
            if($data_len-- == 1){
                $douh='';}
            if(is_numeric($value)){
                $qz="";}
            else{
                $qz="'";}
            $sql.='`'.$key.'`='.$qz.$value.$qz.$douh;}
        $sql.=' '.$this->where.' ;';
        if ($this->conn->query($sql) === TRUE) {
            return mysqli_affected_rows($this->conn);
        } else {
            Debug($this->conn->error,$sql) ;}
    }

    /**
     * 依靠where 自增
    **/
    public function setInc($field,$number=1){

        $sql='UPDATE `'.self::$table.'` SET `'.$field.'`='.$field.'+'.$number .$this->where .';';
        if ($this->conn->query($sql) === TRUE) {
            return mysqli_affected_rows($this->conn);}
        else {
            Debug($this->conn->error,$sql);}
    }
    /**
     * 依靠where 自减
     **/
    public function setDec($field,$number=1){

        $sql='UPDATE `'.self::$table.'` SET `'.$field.'`='.$field.'-'.$number .$this->where .';';
        if ($this->conn->query($sql) === TRUE) {
            return mysqli_affected_rows($this->conn);}
        else {
            Debug($this->conn->error,$sql);}
    }

    /**
     * 依靠where 批量删除数据，返回删除成功的条数
     * @return int
     * DELETE FROM Course WHERE `cno`=23;
     **/
    public function delect($key=''){
        $sql='DELETE FROM `'.self::$table.'`';
        if(empty($key)){
            $sql.=' '.$this->where.';';
            if(empty($this->where)){
                Debug('缺少删除条件！',$sql);}
        }else{
            $sql.=' WHERE `'.self::$table_index.'`='.$key.';';}
        if ($this->conn->query($sql) === TRUE) {
            return mysqli_affected_rows($this->conn);}
        else {
            Debug($this->conn->error,$sql) ;}
    }

}