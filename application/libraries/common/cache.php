<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * 封装redis连接类方便在本地和生产环境中切换
 *
 */
class Cache{
   
    /* 这里替换为连接的实例host和port */
    private  $host =  '';
    
    private  $port =  '';    
    /* 这里替换为实例id和实例password */
    private  $user = "";
    
    private  $pwd = "";
    /*redis 对象*/
    public   $_redis='';
    
    public   $link = true;
     
    /**
     * 获取redis对象
     * @return  object  redis
     */
    function getRedis($option){
        $this->_redis = new Redis();
        $this->host=$option['host'];
        $this->port=$option['port'];
        $this->user=$option['user'];
        $this->pwd=$option['pwd'];
        switch ($option['environment']){
            case 'production':
                $result=$this->connectAiYun();
                return $result;
                break;
                 
            case 'development':
                $result=$this->connectTest();
                return $result;
                break;
        }
    }
   /**
    * 阿里云连接redis
    * @param  string  host  连接地址
    * @param  int     port  端口号
    * @param  string  user  账号
    * @param  string  pwd  密码
    * @return 连接失败 返回 false 错误原因
    */
    function connectAiYun(){
        if ($this->_redis->connect($this->host, $this->port) == false) {
            $this->link  = false;
            $this->error = $this->_redis->getLastError();
            return false;
        }
        /* user:password 拼接成AUTH的密码 */
        if ($this->_redis->auth($this->user . ":" . $this->pwd) == false) {
            $this->link = false;
            $this->error = $this->_redis->getLastError();
            return false;
        }
        return  $this->_redis;
    }
    /**
     * 测试环境连接redis
    * @param  string  host  连接地址
    * @param  int     port  端口号
    * @param  string  pwd  密码
    * @return 连接失败 返回 false 错误原因
     */
    function connectTest(){ 
        if( $this->_redis->connect($this->host,$this->port) === false){
            $this->link  = false;
            $this->error = $this->_redis->getLastError();
            return false;
        }
        if( $this->_redis->auth($this->pwd) === false ){
            $this->link  = false;
            $this->error = $this->_redis->getLastError();
            return false;
        };
        return  $this->_redis;
    }
    /**
     * key 类型 赋值
     * @param   string   key     键
     * @param   string   val     值
     * @param   bool     cover   是否覆盖
     * @param   int      expire 过期时间
     * @return  bool 设置成功返回 true | 失败返回  false 原因
     */
      function setKey(){
        //判断redis  是否正确 初始化
        if($this->link === false){
            return false;
        }
        //校验当前需要赋值的key 是否已经设置
        if(!$this->_redis->exists($this->key)){
            $cache=$this->_redis->set($this->key,$this->val);            
        }else{
            if(isset($this->cover) && $this->cover){
                $cache=$this->_redis->set($this->key,$this->val);
            }else{
                $this->error='redis 已经存在key('.$this->key.')';
                return false;
            }
        }
        if( $cache === false ){
            $this->error=$this->_redis->getLastError();
            return false;
        }
        //检测时候需要设置过期时间
        if(isset($this->expire) && !empty($this->expire)){
            $cache_time=$this->_redis->expire($this->key,$this->expire);           
        }else{
            $cache_time=true;
        }
        if($cache_time === false){
            $this->error=$this->_redis->getLastError();
            return false;
        }
        return true;
    }
    /**
     * 校验当前的key 是否存在 存在返回值 否则返回 false
     * @param   strng   key  键
     * @return  string 存在返回结果 | bool 不存在返回 false
     */
    function existsKey(){
        //判断redis  是否正确 初始化
        if($this->link === false){
            return false;
        }
        //校验当前需要赋值的key 是否已经设置
        if($this->_redis->exists($this->key)){
             $response=$this->_redis->get($this->key);
             return $response;
        }else{
            $this->error='redis 已经不存在key('.$this->key.')';
            return false;
        }
    }
    /**
     * 选择数据库 不存在 返回false
     * @param  int   number  数据库编号
     * @return   bool  成功返回 true | 失败返回false
     */
    function selectDB(){
        //判断redis  是否正确 初始化
        if($this->link === false){
            return false;
        }
        $res=$this->_redis->select($this->number);        
    }
}