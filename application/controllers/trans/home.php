<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Content-type:text/html;charset=utf-8');
session_start();
class Home extends CI_Controller{  
     /**
     * 系统后台登录页面
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
        $smarty->display('trans/home.html');
	}
    public function loginin(){
    	//校验获取参数
    	$data=$this->input->post();
     	foreach ($data as $k=>$v){
     		if(empty($v)){
     			Universal::Output($this->config->item('request_fall'),'没有获取必填参数的值');
     		}
     	}
    	$this->load->model('trans/home_model'); 
    	$this->home_model->name=$data['name'];
    	$this->home_model->pwd=$data['pwd'];
    	$result = $this->home_model->check_user();
    	if ($result==false) {
     		currency::Output($this->config->item('request_fall'),'用户名或密码错误','','');
    	}
     	currency::Output($this->config->item('request_succ'),'登录成功','../trans/trans/',$result);
    }
      /**
     * 添加新代理
     * @since 2017/02/08
     * @version v1.0
     * @author sunbeike
     * @return Array
     */
    public function addAgent(){
    	//加载smarty模板
    	$this->load->library('smarty/tpl');
    	$smarty=$this->tpl->getSmarty();
    	$smarty->caching = false;
    	// 校验用户是否在线
    	currency::checkOnline();
    	$user=currency::getUser();//用户信息
    	if (!is_numeric($user['id']=$_SESSION['id'])) {
    		header('../trans/home');
    	}
    	$smarty->assign('tag',$_SESSION['tag']);
    	$smarty->display('trans/addAgent.html');
    }
    /**
     * 把新代理数据保存到数据库里面
     */
    public function saveAgent(){
    	$this->load->helper('phpqrcode');
    	//校验获取参数
    	$data=$this->input->post();
    	foreach ($data as $k=>$v){
    		if(empty($v)){
    			Universal::Output($this->config->item('request_fall'),'没有获取必填参数的值');
    		}
    	}
    	$this->load->model('trans/home_model');
    	$this->home_model->phone = $data['phone'];
    	$this->home_model->tag = $data['tag'];
    	$AgentResult = $this->home_model->selectAgent();
    	if($AgentResult != '0'){
    		$this->home_model->proportion = $data['proportion'];
    		$this->home_model->id = $_SESSION['id'];
    		$result = $this->home_model->addNewAgent();
    		if ($result!=null) {
    			currency::Output($this->config->item('request_succ'),'添加成功','../trans/',$result);
    		}
    		currency::Output($this->config->item('request_fall'),'该手机号已经存在,请重新填写');
    	}else{
    		currency::Output($this->config->item('request_fall'),'该手机号未注册','../trans/addAgent');
    	}
    }
    //冻结代理账户
    function gethandle(){
    	//校验获取参数
    	$data=$this->input->post();
    	foreach ($data as $k=>$v){
    		if(empty($v)){
    			Universal::Output($this->config->item('request_fall'),'没有获取必填参数的值');
    		}
    	}
    	$this->load->model('trans/home_model');
    	$this->home_model->id = $data['id'];
    	$this->home_model->tag = $data['tag'];
    	//tage  1冻结二级代理 2冻结推广员
    	if($this->home_model->tag == 1){
    		$result = $this->home_model->uptrans();
    	}else if($this->home_model->tag == 2){
    		$result = $this->home_model->uppromoter();
    	}
    	if ($result==false) {
    		currency::Output($this->config->item('request_fall'),'未知错误','','');
    	}
    	currency::Output($this->config->item('request_succ'),'','',$result);
    }
}