<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * 用户相关的操作
 */
class user_model extends CI_Model{
    
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
   /**
    * 根据账号查询用户是否存在 密码是否相等
    * @param   int     name  账号
    * @param   string  pwd  密码
    * @return  bool  校验通过返回true|校验失败返回false
    */
   function userAuth() {
       $sql='select wx_id,wx_name,wx_mobile,wx_password,wx_openid,wx_img from
       h_wxuser where wx_mobile='.$this->name;
       $query=$this->db->query($sql);
       if($query->num_rows < 1){
            $result = $this->GetjstUser('http://platform.91jst.com/Consign/Server/User/public/usr/verifybytel.php?tel='.$this->name
                .'&pwd='.$this->pwd.'&secret=abcdefgABCDEFG0987654321');
            if ($result==false) {//没有的话去寄售商城获取账户
                $return = $this->GetjstUser('http://www.91jst.com/new/verifyshopbytel.php?tel='.$this->name
                    .'&pwd='.$this->pwd.'&secret=abcdefg');
                if (!$return) {
                    return false;
                }
                return true;
            }
            return true;
       }
       $password=hash('sha256',$this->pwd);
       $result=$query->result_array();
       if($result['0']['wx_password'] !=  $password){
           return false;
       }else{
           $_SESSION['user_online']='ok';
           $_SESSION['user_id']=$result['0']['wx_id'];
           $_SESSION['user_mobile']=$result['0']['wx_mobile'];
           $_SESSION['user_openid']=$result['0']['wx_openid'];
           $_SESSION['user_name']=$result['0']['wx_name'];
           $_SESSION['user_img']=$result['0']['wx_img'];
           return true;
       } 
   }
   
   
   
    /**
     * 获取寄售通的账户信息，并且插入信息
     * @param       url       string         要请求的链接
     */
    function GetjstUser($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $data=json_decode($result,true);
        if ($data['result']==0) {//成功则插入账户信息
            $this->passwd = $this->pwd;
            $this->mobile = $this->name;
            $this->user_model->ip=$this->input->ip_address();
            $result = $this->register();
            if ($result==false) {
                return false;
            }
            return true;
        }else{//用户密码错误
            return false;
        }
    }
    /**
     * 修改密码，通知寄售通
     * @param    $url       链接的地址
     */
    function noticJstChange($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $data=json_decode($result,true);
    }
   /**
    * 用户根据短信验证码登录 读取用户记录
    * @param  int  mobile 手机号码
    * @return  读取成功返回 array | 读取失败 返回 bool false
    */
   function mobileAuth(){
       $sql='select wx_id,wx_name,wx_mobile,wx_password,wx_openid,wx_img from
             h_wxuser where wx_mobile='.$this->mobile;
       $query=$this->db->query($sql);
       if($query->num_rows < 1){
           return false;
       }else{
           $result=$query->result_array();
           $_SESSION['user_online']='ok';
           $_SESSION['user_id']=$result['0']['wx_id'];
           $_SESSION['user_mobile']=$result['0']['wx_mobile'];
           $_SESSION['user_openid']=$result['0']['wx_openid'];
           $_SESSION['user_name']=$result['0']['wx_name'];
           $_SESSION['user_img']=$result['0']['wx_img'];
           return true;
       }
   }
   //会员通过手机号码注册
   function register() {
       $password=hash('sha256',$this->pwd);
       $data=array(
               'wx_name'=>'手机用户_'.substr($this->mobile, 7),
               'wx_mobile'=>$this->mobile,
               'wx_password'=>$password,
               'wx_jointime'=>date('Y-m-d H:i:s'),
               'wx_logintime'=>date('Y-m-d H:i:s'),
               'wx_regtime'=>date('Y-m-d H:i:s'),
               'wx_loginip'=>$this->ip,
               'wx_status'=>1
       );
       if (isset($_SESSION['user_from'])&&ctype_alnum($_SESSION['user_from'])
           &&strlen($_SESSION['user_from'])<=7) {
           $data['wx_spreadnum'] = $_SESSION['user_from'];
       }
       $this->db->insert('h_wxuser',$data);
       $row=$this->db->affected_rows();
       if($row == 1){
            $this->mobileAuth();
            if (isset($_SESSION['user_id'])&&is_numeric($_SESSION['user_id'])) {
                $this->is_have_user($_SESSION['user_id']);
            }
            return true;
       }else{
           return false;
       }
   }
   /**
    * 修改密码
    * @param   int     mobile  手机号码
    * @param   string  pwd     密码
    * @return  修改成功返回bool true| 修改失败返回 bool false
    */
   function upPassword() {
       $password=hash('sha256',$this->pwd);
       $where=array(
               'wx_mobile'=>$this->mobile
       );
       $data=array(
               'wx_password'=>$password,
               'wx_updatetime'=>date('Y-m-d H:i:s')
       );
       $this->db->update('h_wxuser',$data,$where);
       $row=$this->db->affected_rows();
       if($row == 1){          
           return true;
       }else{
           return false;
       }
   }
   /**
    * 更新用户最后一次登录时间,IP 信息
    * @param   string  ip    最后一次登录IP
    * @param   int     time  最后一次登录时间
    * @return  bool  更新成功返回 true | 更新失败返回false
    */
   function upLoginInfo(){
       $data=array(
               'wx_logintime'=>date('Y-m-d H:i:s'),
               'wx_loginip'=>$this->ip
       );
       $where=array(
               'wx_id'=>$this->id
       );
       $query=$this->db->update('h_wxuser',$data,$where);
       if($query || $this->db->affected_rows() ==1){
           return  true;
       }else{
           $filename='./logs/runing/'.date('Y-m-d').'.log';
           $content=date('Y-m-d H:i:s').'用户模块更新最后登录时间出现异常!';
           currency::SystemLog($filename, $content);
           return  false;
       }
   }
   /**
    * 短信登录 校验当前手机号码是否存在
    * @param  int  mobile 手机号码
    * @return  存在返回 bool true | 不存在返回 false
    */
   function isMobile(){
       $sql='select wx_mobile from h_wxuser where wx_mobile='.$this->mobile;
       $query=$this->db->query($sql);
       if($query->num_rows < 1){
           return false;
       }else{
           return true;
       }
   }

    /**
     * 功能：判断任务中心是否有此用户,没有直接插入
     * @param   wx_id     用户的id
     * @param   string    field          要取得的字段(字符串必须以“,”开头)
     * @return  true|array    查到用户则返回用户信息，无信息则插入信息 成功返回true
     */
    public function is_have_user($wx_id,$field=''){
        $sql = 'select center_id,center_status'.$field.' from h_wxuser_task where wx_id='.$wx_id;
        $data = $this->db->query($sql);
        if ($data->num_rows >= 1) {//如果有此号，直接返回数组
            return $data->result_array();
        }
        //如果用户中心没有此用户信息，则新插入一个。
        $is_have = 0;
        while ($is_have == 0) {
            $center_extend_num = substr(implode(NULL, str_split(substr(uniqid(), 7, 13), 1)), 0, 8);
            $sql = 'select wx_id from h_wxuser_task where center_extend_num="'.$center_extend_num.'"';
            $str = $this->db->query($sql)->result_array();
            if (!empty($str)) {
              $is_have = 0;
            }else{
              $is_have = 1;
            }
        }
        $sql = 'insert into h_wxuser_task (wx_id,center_extend_num,center_jointime,center_fund,center_integral) 
                value('.$wx_id.',"'.$center_extend_num.'",'.time().',50,300)';
        $str = $this->db->query($sql);
        if ($str === false) {
          return false;
        }
        $this->extends = $center_extend_num;
        $this->load->library('common/cache',$this->config->item('redis_config_aliyun'));//redis加载
        $this->cache->getRedis($this->config->item('redis_config_aliyun'));
        if ($this->cache->link===true) {
            $str = $this->cache->_redis->exists('task_user');
            if ($str==1) {
              $this->cache->_redis->incr('task_user');
            }
        }
        return true;
  }
}