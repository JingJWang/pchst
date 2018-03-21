<?php
/**
 * 短信模块
 * 用于系统内  所有调用短信接口 
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Msg_model extends CI_Model {
    
    //验证码表    
    private   $verify_code  =  'h_verify_code';
    //短信类型
    public    $code_type    =  ''; 
    //发送类型
    public    $type         =  '';
    //加载数据库类
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
   /**
     * 发送短信验证码
     * @param   int     mobile    手机号码
     * @param   array   content   发送内容
     * @param   string  type      发送类型   notice 通知类型    verify 验证类型
     * @param   int     template  短信模板id
     * @return  boolean 发送成功返回 true | 失败返回  false
     */  
    function  sendVerify(){        
        if(empty($this->mobile) || empty($this->number)){
            return  $this->lang->line('msg_check_content'); 
        }
        if(!is_numeric($this->mobile) || isset($this->mobile{11})){
            return  $this->lang->line('msg_check_format'); 
        }        
        $this->load->library('alidayu/alimsg');
        $this->alimsg=new Alimsg();
        $this->alimsg->appkey=$this->config->item('alidayu_appkey');
        $this->alimsg->secret=$this->config->item('alidayu_secretKey');
        $this->alimsg->extend=$this->config->item('alidayu_extend');
        $this->alimsg->sign=$this->config->item('alidayu_signname');
        $this->alimsg->shownum=$this->config->item('alidayu_shownum');
        $this->alimsg->mobile=$this->mobile;
        $this->alimsg->template=$this->templte;
        $this->alimsg->content=json_encode(array('product'=>'回收通','code'=>$this->number));
        $response=$this->alimsg->SendVerifyCode();
        $res=$this->SaveSms($response);
        return $res;
    }     
    /**
     * 保存当前短信验证码发送记录
     * @param   string  content  短信内容
     * @return  发送成功返回bool  true  | 发送失败 bool false
     */
    function  SaveSms($response){
        if($response === true){
            $data=array('code_type'=>$this->code_type,'code_moblie'=>$this->mobile,
                    'code_number'=>$this->number,'code_jointime'=>time(),
                    'response_status'=>$this->alimsg->code,
                    'response_sid'=>$this->alimsg->msg,'code_status'=>1);
            //保存发送内容
            $query=$this->db->insert($this->verify_code,$data);
            if($query){
                return  true;
            }else{
                return false;
            }
        }
        if($response === false){
            $data=array('code_type'=>$this->code_type,'code_moblie'=>$this->mobile,
                    'code_number'=>$this->number,'code_jointime'=>time(),
                    'response_status'=>$this->alimsg->code,
                    'response_info'=>$this->alimsg->msg,'code_status'=>0);
            $query=$this->db->insert($this->verify_code,$data);
            if($query){
                return  false;
            }else{
                return false;
            }
        }
    } 
    /**
     * 用户模块-校验验证码是否正确  
     * @param      int     mobile   手机号码
     * @param      string  code     验证码
     * @param      int     type     类型  例如 注册 验证码  提现验证码
     * @param      int     invalid  失效时间
     * @return     成功返回 bool | true , 校验失败返回 bool | false
     */
    function check_code(){        
         $sql='select code_id,code_jointime,code_moblie from '.$this->verify_code.'
              where  code_moblie='.$this->mobile.' and code_number='.$this->code.' 
              and code_status=1  and response_status='.$this->config->item('alidayu_sendsucc').' 
              and  code_type='.$this->type;
        $query=$this->db->query($sql);
        if($query ===  false  || $query->num_rows() < 1){
            return false;
        }
        $result=$query->result_array();        
        if(time() - $result['0']['code_jointime'] > $this->invalid ){
            $res=$this->upMsgStatus($result['0']['code_id'], '-2');
            return  false;
        }
        //验证码校验成功
        $res=$this->upMsgStatus($result['0']['code_id'], '-1');
        return $res;
    }
    /**
     * 更改信息状态
     * @param      int      id      信息id
     * @param      int      sttaus  状态
     * @return     bool             返回结果
     */
    function upMsgStatus($id,$status){
        $data=array('code_updatetime'=>time(),'code_status'=>$status);
        $where=array('code_id'=>$id);
        $this->db->update($this->verify_code,$data,$where);
        $row=$this->db->affected_rows();
        if( 1 == $row ){
            return true;
        }
        return false;
    }
    /**
     * 生成随机字符串
     * @param   int      len      长度
     * @param   string   format   格式  ALL  CHAR  NUMBER
     * @return  string   返回生成的字符串
     */    
    function randStr($len=6,$format='ALL') {
        switch($format) {
            case 'ALL':
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789'; 
                break;
            case 'CHAR':
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
                break;
            case 'NUMBER':
                $chars='123456789'; 
                break;
            default :
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                break;
        }
        mt_srand((double)microtime()*1000000*getmypid());
        $content="";
        while(strlen($content)<$len){
            $content.=substr($chars,(mt_rand()%strlen($chars)),1);
        }
        return $content;
    }
    
    /**
     * 阿里大鱼  短信验证码  用户提现
     * @param    int        mobile      手机号码
     * @param    array      content     内容
     * @param    string     type        短信类型
     * @param    string     sign        短信签名
     * @param    string     extend      回传数据
     * @param    string     template    短信模板
     * @return  发送成功返回bool  true  | 发送失败 bool false
     */
    function  UserExtractCash(){
        $this->load->library('alidayu/alimsg');
        $this->alimsg=new Alimsg();
        $this->alimsg->mobile=$this->mobile;
        $this->alimsg->appkey=$this->config->item('alidayu_appkey');
        $this->alimsg->secret=$this->config->item('alidayu_secretKey');
        $this->alimsg->sign=$this->config->item('alidayu_signname');
        $this->alimsg->template=$this->config->item('alidayu_templte_extractcash');
        $this->number=$this->randStr(6,'NUMBER');
        $this->alimsg->content="{\"code\":\"".$this->number."\",\"minute\":\"5\"}";
        $response=$this->alimsg->SendVerifyCode();
        $res=$this->SaveSms($response);
        return $res;
    }
    /**
     * 阿里大鱼  校验当前的验证码是否正确
     * @param   int     mobile  手机号码
     * @param   int     minute  超时条件(分钟)
     * @param   int     type    验证码分类
     * @param   string  code    验证码
     * @return  校验成功 返回 bool  true | 校验失败返回  false
     */
    function CheckVerify(){
        if(empty($this->mobile) || empty($this->code)){
            return  false ;
        }
        if(!is_numeric($this->mobile) || !is_numeric($this->code) 
                || !is_numeric($this->minute)){
            return  false;
        }
        $sql='select code_id,code_jointime,code_moblie from '.$this->verify_code.'
              where  code_moblie='.$this->mobile.' and code_number='.$this->code.'
              and code_status=1  and response_status='.$this->config->item('alidayu_sendsucc').'
              and  code_type='.$this->type;
        $query=$this->db->query($sql);
        if($query ===  false  || $query->num_rows() < 1){
            return false;
        }
        $result=$query->result_array();
        if(time() - $result['0']['code_jointime'] > $this->minute*60 ){
            $data=array('code_status'=>'-2');
            $where=array('code_id'=>$result['0']['code_id']);
            $query=$this->db->update($this->verify_code,$data,$where,array());
            return  false;
        }
        //验证码校验成功
        $res=$this->edit_msgstatus($result['0']['code_id'], '-1');
        return $res;
    }
    /**
     * 阿里大鱼  发送语音验证码  用户注册
     * @param   string   appkey  应用id
     * @param   string   secret  秘钥
     * @param   string   extend  回传数据
     * @param   int      mobile  手机号码
     * @param   string   shownum 去电号码
     * @param   int      templte 模板id
     * @return  发送成功返回bool  true  | 发送失败 bool false
     */
    function SendVoiceCode(){  
        $this->load->library('alidayu/alimsg'); 
        $this->alimsg=new Alimsg();
        $this->alimsg->appkey=$this->config->item('alidayu_appkey');      
        $this->alimsg->secret=$this->config->item('alidayu_secretKey');
        $this->alimsg->extend=$this->config->item('alidayu_extend');
        $this->alimsg->mobile=$this->mobile;
        $this->alimsg->shownum=$this->config->item('alidayu_shownum');
        $this->alimsg->templte=$this->config->item('alidayu_templte_voicecode');
        $this->number=$this->msg_model->randStr(6,'NUMBER');
        $this->alimsg->content=json_encode(array('product'=>'回收通','code'=>$this->number)); 
        $response=$this->alimsg->SendVoiceCode();
        $res=$this->SaveSms($response);
        return $res;
    }
    
    /**
     * 校验当前手机号码是否已经存在
     * @param    int  mobile  手机号码
     * @return   存在返回false | 不存在返回false
     */
    function CheckMobile(){
        $check_sql='select wx_id from  h_wxuser  where  wx_mobile="'.$this->mobile.'"';
        $check_row=$this->db->query($check_sql);
        if($check_row->num_rows >0){
           return false;
        }
        return true;
    }
    /**
     * 校验当前手机号码是否超过当前发送上限
     * @param   int  mobile     手机号码
     * @param   int  code_limit 校验次数
     * @param   int  code_type  校验类型
     * @return  超过上限返回 bool false | 没有超过上限返回bool true
     */
    function CheckNum(){        
        $sql='select code_id,code_jointime from '.$this->verify_code.' where code_jointime > '.
                strtotime("-1 day").' and code_jointime < "'.time().'" and code_moblie="'.
                $this->mobile.'" and code_type='.$this->code_type;
        $query=$this->db->query($sql);
        if($query->num_rows >= $this->code_limit){
           return false;
        }
        $data=$query->result_array();
        $content=end($data);
        if(time() - $content['code_jointime'] < 60 ){
           return false;
        }
        return true;
    }
    /**
     * 注册校验-校验同一个IP注册的账号数量
     * @param    string  ip  当前注册的ip
     * @return  bool  返回校验的结果
     */
    function checkRegister(){
            $sql='select wx_id from h_wxuser where wx_loginip="'.$this->ip.'"';            
            $query=$this->db->query($sql);
            if($query === false || $query->num_rows > 3){
                return false;
            }
            return true;
    }
    /**
     * 系统异常发送短信通知运维人员
     */
    function sendWarning(){
        $this->load->library('alidayu/alimsg');
        $this->alimsg=new Alimsg();
        $this->alimsg->appkey=$this->config->item('alidayu_appkey');
        $this->alimsg->secret=$this->config->item('alidayu_secretKey');
        $this->alimsg->extend=$this->config->item('alidayu_extend');
        $this->alimsg->sign=$this->config->item('alidayu_signname');
        $this->alimsg->mobile=$this->mobile;
        $this->alimsg->shownum=$this->config->item('alidayu_shownum');
        $this->alimsg->template=$this->template;
        $this->alimsg->content=json_encode(array('time'=>$this->time,'make'=>$this->msg,'content'=>$this->content));
        $response=$this->alimsg->SendNotice();
        return $response;
    }
}