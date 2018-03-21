<?php
session_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends  CI_Controller{    
    /**
     * 显示登录页面
     */
    function login(){
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('foots',$texts);
        $smarty->display('common/login.html');
    }
    /**
     * 显示注册页面
     */
    function  register(){
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('foots',$texts);
        $smarty->display('common/register.html');
    }
    /**
     * 显示找回密码页面
     */
    function backpwd(){
        $this->load->model('notice_model');
        $texts = $this->notice_model->getAllNotice();
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('foots',$texts);
        $smarty->display('common/backpwd.html');
    }
    /**
     * (账号密码方式登陆)校验用户本次登录是否合法
     * @param   int     name  用户名
     * @param   string  pwd   密码
     * @return  返回登陆结果
     */
    function islogin(){
        //校验当前登陆是否开启验证码校验
        if(isset($_SESSION['check_code']) && $_SESSION['check_code'] == 1){
            $code=$this->input->post('code',true);
            if($_SESSION['hst_code'] != $code){
                currency::Output($this->config->item('request_fall'),$this->lang->line('common_verify_fall'));
            }
        }        
        $name=$this->input->post('name');
        if(!is_numeric($name) || isset($name{11})){
            currency::Output($this->config->item('request_fall'),$this->lang->line('common_request_format'));
        }
        $pwd=$this->input->post('pwd');
        if(empty($pwd)){
            currency::Output($this->config->item('request_fall'),$this->lang->line('common_request_format'));
        }
        $this->load->model('common/user_model');
        $this->user_model->name=$name;
        $this->user_model->pwd=currency::safe_replace($pwd);
        $auth=$this->user_model->userAuth();
        if($auth){
            $ip=$this->input->ip_address();
            $this->user_model->ip=$ip;
            $this->user_model->id=$_SESSION['user_id'];
            $this->user_model->upLoginInfo();
            currency::Output($this->config->item('request_succ'),'','/index.php/center/info');
        }else{
            //本次会话开启验证码
            $_SESSION['check_code']=1;
            currency::Output($this->config->item('request_fall'),$this->lang->line('user_login_fall'),'',array('code'=>1));
        }
    }
    /**
     * (手机验证码登陆)校验当前登陆是否合法
     * @param  int     mobile   手机号码
     * @param  string  code     手机验证码
     * @param  string  verify   随机验证码
     */
    function mobileLogin(){
        //校验随机验证码
        $code=$this->input->post('code',true);
        if(empty($code) || $code !=$_SESSION['hst_code']){
            currency::Output($this->config->item('request_fall'),$this->lang->line('common_verify_fall'));
        }
        //校验手机号码格式是否正确
        $mobile=$this->input->post('mobile',true);
        if(!is_numeric($mobile) || isset($mobile{11})){
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_check_format'));
        }
        //校验短信验证码是否正确
        $verify=$this->input->post('verify');
        if(!is_numeric($verify) || isset($verify{6})){
            currency::Output($this->config->item('request_fall'),$this->lang->line('verify_format_fall'));
        }
        //校验当前验证码是否正确
        $this->load->model('common/msg_model');
        $this->msg_model->code=$verify;
        $this->msg_model->mobile=$mobile;
        $this->msg_model->type=81;
        $this->msg_model->invalid=300;
        $result=$this->msg_model->check_code();
        if(!$result){
            currency::Output($this->config->item('request_fall'),$this->lang->line('check_verify_fall'));
        }
        //读取用户的信息
        $this->load->model('common/user_model');
        $this->user_model->mobile=$mobile;
        $resp=$this->user_model->mobileAuth();
        if($resp){
            $ip=$this->input->ip_address();
            $this->user_model->ip=$ip;
            $this->user_model->id=$_SESSION['user_id'];
            $this->user_model->upLoginInfo();
            
            currency::Output($this->config->item('request_succ'),'','/index.php/center/info');
        }else{
            //本次会话开启验证码
            $_SESSION['check_code']=1;
            currency::Output($this->config->item('request_fall'),$this->lang->line('user_login_fall'));
        }
    }
    /**
     * 微信登录 显示登陆二维码
     */
    function loginimg(){
        $state=hash('sha256',time());
        $this->load->model('common/wxcode_model');
        $openid=$this->wxcode_model->img($state);
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->assign('img',$openid);
        $smarty->display('common/wxlogin.html');
    }
    /**
     * 请求登录接口
     */
    function wxlogin(){
        
        
    }
    /**
     * 获取登录用的短信验证码
     * @param  int  mobile 手机号码
     * @param  int  code   随机验证码
     * @return  json  结果
     */
    function sendVerify(){
        //校验每次请求的时间
        if(isset($_SESSION['logintime'])){
             $disparity= time() - $_SESSION['logintime'] ;
             if($disparity < 60){
                 currency::Output($this->config->item('request_fall'),$this->lang->line('common_request_time'));
             }
        }else{
            $_SESSION['logintime']=time();
        }
        //校验随机验证码
        $code=$this->input->post('code',true);
        if(empty($code) || $code !=$_SESSION['hst_code']){
            currency::Output($this->config->item('request_fall'),$this->lang->line('common_verify_fall'));
        }
        //校验手机号码格式是否正确
        $mobile=$this->input->post('mobile',true);
        if(!is_numeric($mobile) || isset($mobile{11})){
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_check_format'));
        }
        //校验当前手机号码是否是会员账号
        $this->load->model('common/user_model');
        $this->user_model->mobile=$mobile;
        $result=$this->user_model->isMobile();
        if(!$result){
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_check_format'));
        }
        //校验当前手机号码当天发送验证码的次数
        $this->load->model('common/msg_model');
        $this->msg_model->mobile=$mobile;
        $this->msg_model->code_limit=3;
        $this->msg_model->code_type=81;
        $result=$this->msg_model->CheckNum();
        if(!$result){
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_send_limie'));
        }
        //发送短信验证码
        $this->load->model('common/msg_model');
        $this->msg_model->mobile=$mobile;
        $this->msg_model->code_type=81;
        $this->msg_model->code_limit=3;
        $this->msg_model->templte=$this->config->item('alidayu_templte_register');
        $this->msg_model->number=$this->msg_model->randStr(6,'NUMBER');
        $response=$this->msg_model->sendVerify();
        if($response){
            currency::Output($this->config->item('request_succ'),$this->lang->line('msg_verify_succ'));
        }else{
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_verify_fall'));
        }
    }
    /**
     * 手机号码注册会员
     * @param   int     mobile   手机号码
     * @param   int     code     随机验证码
     * @param   int     verify   短信验证码
     * @param   string  pwd      账号密码
     */
    function mRegister(){
        //校验每次请求的时间
        if(isset($_SESSION['regitime'])){
            $disparity= time() - $_SESSION['regitime'] ;
            if($disparity < 2){
                currency::Output($this->config->item('request_fall'),$this->lang->line('common_request_time'));
            }
        }else{
            $_SESSION['regitime']=time();
        }
        //校验随机验证码
        $code=$this->input->post('code',true);
        if(empty($code) || $code !=$_SESSION['hst_code']){
            currency::Output($this->config->item('request_fall'),$this->lang->line('common_verify_fall'));
        }
        //校验手机号码格式是否正确
        $mobile=$this->input->post('mobile',true);
        if(!is_numeric($mobile) || isset($mobile{11})){
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_check_format'));
        }
        //校验短信验证码格式
        $verify=$this->input->post('verify',true);
        if(!is_numeric($verify) || isset($verify{6})){
            currency::Output($this->config->item('request_fall'),$this->lang->line('verify_format_fall'));
        }
        $pwd=$this->input->post('pwd',true);
        if(empty($pwd) || !isset($pwd{6})){
            currency::Output($this->config->item('request_fall'),$this->lang->line('user_refiter_pwd'));
        }
        //校验当前验证码是否正确
        $this->load->model('common/msg_model');
        $this->msg_model->code=$verify;
        $this->msg_model->mobile=$mobile;
        $this->msg_model->type=82;
        $this->msg_model->invalid=300;
        $result=$this->msg_model->check_code();
        if(!$result){
            currency::Output($this->config->item('request_fall'),$this->lang->line('check_verify_fall'));
        }
        //注册会员账号
        $this->load->model('common/user_model');
        $this->user_model->mobile=$mobile;
        $this->user_model->pwd=$pwd;
        $ip=$this->input->ip_address();
        $this->user_model->ip=$ip;
        $res=$this->user_model->register();
        if($res){
            //注册来源为提交订单前 注册成功后  继续提前订单
            if(isset($_SESSION['user_goback']) && !empty($_SESSION['user_goback'])){
                $url=$_SESSION['user_goback'];
            }else{               
                $url='/index.php/center/info';
            }
            currency::Output($this->config->item('request_succ'),'',$url);
        }else{
            currency::Output($this->config->item('request_fall'),$this->lang->line('user_login_fall'));
        }
    }   
    /**
     * 手机号码注册会员发送验证码
     * @param  int  mobile 手机号码
     * @param  int  code  随机验证码
     * @return json 结果
     */
    function  registerMsg(){
        //校验每次请求的时间
        if(isset($_SESSION['registertime'])){
            $disparity= time() - $_SESSION['registertime'] ;
            if($disparity < 60){
                currency::Output($this->config->item('request_fall'),$this->lang->line('common_request_time'));
            }
        }else{
            $_SESSION['registertime']=time();
        }
        //校验随机验证码
        $code=$this->input->post('code',true);
        if(empty($code) || $code !=$_SESSION['hst_code']){
            currency::Output($this->config->item('request_fall'),$this->lang->line('common_verify_fall'));
        }
        //校验手机号码格式是否正确
        $mobile=$this->input->post('mobile',true);
        if(!is_numeric($mobile) || isset($mobile{11})){
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_check_format'));
        }
        //校验当前手机号码是否是会员账号
        $this->load->model('common/user_model');
        $this->user_model->mobile=$mobile;
        $result=$this->user_model->isMobile();
        if($result){
            currency::Output(2000,$this->lang->line('user_refiter_occupy'));
        }
        //校验当前手机号码当天发送验证码的次数
        $this->load->model('common/msg_model');
        $this->msg_model->mobile=$mobile;
        $this->msg_model->code_limit=3;
        $this->msg_model->code_type=82;
        $result=$this->msg_model->CheckNum();
        if(!$result){
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_send_limie'));
        }
        //发送短信验证码
        $this->load->model('common/msg_model');
        $this->msg_model->mobile=$mobile;
        $this->msg_model->code_type=82;
        $this->msg_model->templte=$this->config->item('alidayu_templte_register');
        $this->msg_model->number=$this->msg_model->randStr(6,'NUMBER');
        $response=$this->msg_model->sendVerify();
        if($response){
            currency::Output($this->config->item('request_succ'),$this->lang->line('msg_verify_succ'));
        }else{
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_verify_fall'));
        }
        
        
    }
    /**
     * 找回登录密码,校验用户绑定的手机号码
     * @param  int      mobile 手机号码
     * @param  string   code   随机验证码
     * @param  int      verify 短信验证码
     * @return json  结果
     */
    function upcheck(){ 
        //校验随机验证码
        $code=$this->input->post('code',true);
        if(empty($code) || $code !=$_SESSION['hst_code']){
            currency::Output($this->config->item('request_fall'),$this->lang->line('common_verify_fall'));
        } 
        //校验手机号码格式是否正确
        $mobile=$this->input->post('mobile',true);
        if(!is_numeric($mobile) || isset($mobile{11})){
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_check_format'));
        }
        $verify=$this->input->post('verify',true);
        if(empty($verify) || isset($verify{6})){
            currency::Output($this->config->item('request_fall'),$this->lang->line('check_verify_fall'));
        }
        //校验当前验证码是否正确
        $this->load->model('common/msg_model');
        $this->msg_model->code=$verify;
        $this->msg_model->mobile=$mobile;
        $this->msg_model->type=84;
        $this->msg_model->invalid=300;
        $result=$this->msg_model->check_code();
        if(!$result){
            currency::Output($this->config->item('request_fall'),$this->lang->line('check_verify_fall'));
        }else{
            $_SESSION['backpwd']=$mobile;
            currency::Output($this->config->item('request_succ'));
        } 
    }
    /**
     * 发送找回密码时的短信验证码
     * @param  int  mobile  手机号码
     * @param  string  code 随机验证码
     * @return json  结果
     */
    function backverify(){
        //校验每次请求的时间
        if(isset($_SESSION['backverify'])){
            $disparity= time() - $_SESSION['backverify'] ;
            if($disparity < 60){
                currency::Output($this->config->item('request_fall'),$this->lang->line('common_request_time'));
            }
        }else{
            $_SESSION['backverify']=time();
        }
        //校验随机验证码
        $code=$this->input->post('code',true);
        if(empty($code) || $code !=$_SESSION['hst_code']){
            currency::Output($this->config->item('request_fall'),$this->lang->line('common_verify_fall'));
        }
        //校验手机号码格式是否正确
        $mobile=$this->input->post('mobile',true);
        if(!is_numeric($mobile) || isset($mobile{11})){
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_check_format'));
        }
        //校验当前手机号码是否是会员账号
        $this->load->model('common/user_model');
        $this->user_model->mobile=$mobile;
        $result=$this->user_model->isMobile();
        if(!$result){
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_check_format'));
        }
        //校验当前手机号码当天发送验证码的次数
        $this->load->model('common/msg_model');
        $this->msg_model->mobile=$mobile;
        $this->msg_model->code_limit=3;
        $this->msg_model->code_type=84;
        $result=$this->msg_model->CheckNum();
        if(!$result){
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_send_limie'));
        }
        //发送短信验证码
        $this->load->model('common/msg_model');
        $this->msg_model->mobile=$mobile;
        $this->msg_model->code_type=84;
        $this->msg_model->code_limit=3;
        $this->msg_model->templte=$this->config->item('alidayu_templte_register');
        $this->msg_model->number=$this->msg_model->randStr(6,'NUMBER');
        $response=$this->msg_model->sendVerify();
        if($response){
            currency::Output($this->config->item('request_succ'),$this->lang->line('msg_verify_succ'));
        }else{
            currency::Output($this->config->item('request_fall'),$this->lang->line('msg_verify_fall'));
        }
    }
    /**
     * 用户修改密码
     */
    function uppwd(){
       if(empty($_SESSION['backpwd'])){
            currency::Output($this->config->item('request_fall'));
       }
       $pwd1=$this->input->post('pwd1',true);
       $pwd2=$this->input->post('pwd2',true);
       if(empty($pwd1) || empty($pwd2)){
           currency::Output($this->config->item('request_fall'),$this->lang->line('common_request_format'));
       }
       if($pwd1 != $pwd2){
           currency::Output($this->config->item('request_fall'),$this->lang->line('common_request_format'));
       }
       $this->load->model('common/user_model');
       $this->user_model->mobile=$_SESSION['backpwd'];
       $this->user_model->pwd=$pwd2;
       $response=$this->user_model->upPassword();
       if($response){
            $this->user_model->noticJstChange('http://platform.91jst.com/Consign/Server/User/public/usr/editpwdbytel.php?tel='.$this->user_model->mobile
            .'&pwd='.$pwd2.'&secret=abcdefgABCDEFG0987654321');
            $this->user_model->noticJstChange('http://www.91jst.com/new/editshoppwdbytel.php?tel='.$this->user_model->mobile
            .'&pwd='.$pwd2.'&secret=abcdefg');
           currency::Output($this->config->item('request_succ'));
       }else{
           currency::Output($this->config->item('request_fall'),$this->lang->line('user_uppwd_fall'));
       }
    }    
     /**
     * 校验当前用户是否已经登录
     */
    function isOnline(){
        $address=$this->input->post('address',true);        
        if(isset($_SESSION['user_online']) && $_SESSION['user_online'] == 'ok'){  
            $online=array(
                    '/index.php/user/login',
                    '/index.php/order/digital/option',
            );
            in_array($address, $online)  ? $url='' :  $url='/index.php/center/info';            
            currency::Output($this->config->item('request_succ'),'',$url,array('code'=>0));
         }else{
            $online=array(
                     '/index.php/user/login',
                     '/index.php/user/backpwd',
                     '/index.php/user/register'
            );             
            in_array($address, $online) ? $url='' : $url='/index.php/user/login';
            isset($_SESSION['check_code']) ? $code = $_SESSION['check_code'] : $code=0;
            currency::Output($this->config->item('request_fall'),'',$url,array('code'=>$code));
        }
    }    
    /**
     * 退出本次会话
     */
    function loginOut(){
        session_destroy();
        currency::Output($this->config->item('request_succ'),'',$this->config->item('url_login'));
    }
}