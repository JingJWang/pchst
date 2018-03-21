<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Content-type:text/html;charset=utf-8');
session_start();
class Login extends CI_Controller{  
     /**
     * 推广员系统后台登录页面
     * @since 2017/02/08 
     * @version v1.0
     * @author sunbeike
	 * @return Array
     */
	//载入登陆页面
	public function index(){
		//加载smarty模板
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->caching = false;
        $smarty->display('trans/login.html');
	}
    public function loginin(){
     	//校验获取参数
     	$data=$this->input->post();
     	foreach ($data as $k=>$v){
     		if(empty($v)){
     			Universal::Output($this->config->item('request_fall'),'没有获取必填参数的值');
     		}
     	}
    	$this->load->model('trans/login_model'); 
    	$this->login_model->name=$data['name'];
    	$this->login_model->pwd=$data['pwd'];
    	$result = $this->login_model->check_user();
    	if ($result==false) {
     		currency::Output($this->config->item('request_fall'),'用户名或密码错误','','');
    	}
     	currency::Output($this->config->item('request_succ'),'登录成功','../trans/trans/',$result);
    }
    /**
     * 修改用户密码
     * @author sunbeike
     * @since 2017/02/08
     * @version v1.0
     * @return json数据
     */
    public function modifyPwd(){
    	// 校验用户是否在线
    	currency::checkOnlineCS();
    	$user=currency::getUser();//用户信息
    	if (!is_numeric($user['id']=$_SESSION['id'])) {
    		header('../trans/login');exit;
    	}
    	//校验获取参数
    	$data=$this->input->post();
    	foreach ($data as $k=>$v){
    		if(empty($v)){
    			Universal::Output($this->config->item('request_fall'),'没有获取必填参数的值');
    		}
    	}
    	$this->load->model('trans/login_model');
    	$this->login_model->pwd=$data['pwd'];
    	$this->login_model->name=$_SESSION['name'];
    	$this->login_model->tag=$data['tag'];
    	$result = $this->login_model->update_user();
    	if ($result=false) {
     		currency::Output($this->config->item('request_fall'),'未知错误','','');
    	}
     	currency::Output($this->config->item('request_succ'),'修改成功','../trans/',$result);
    }
    /**
     * 系统设置
     * @author sunbeike
     * @since 2017/02/08
     * @version v1.0
     * @return json数据
     */
    public function intercalate(){
    	//加载smarty模板
    	$this->load->library('smarty/tpl');
    	$smarty=$this->tpl->getSmarty();
    	$smarty->caching = false;
  		// 校验用户是否在线
    	currency::checkOnlineCS();
    	$user=currency::getUser();//用户信息
    	if (!is_numeric($user['id']=$_SESSION['id'])) {
    		header('../trans/login');exit;
    	}
    	$smarty->assign('tag',$_SESSION['tag']);
    	$smarty->display('trans/intercalate.html');
    }
}