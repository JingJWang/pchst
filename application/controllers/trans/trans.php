<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
header('Content-type:text/html;charset=utf-8');
session_start();
class Trans extends CI_Controller{  
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('pagination');
	}
    /**
     * 系统后台首页面
     * @since 2017/02/08 
     * @version v1.0
     * @author sunbeike
	 * @return Array
     */
    public function index(){
    	//加载smarty模板
        $this->load->library('smarty/tpl');
        $smarty=$this->tpl->getSmarty();
        $smarty->caching = false;
        // 校验用户是否在线
        currency::checkOnline();
        $user=currency::getUser();//用户信息
        if(!is_numeric($user['id'])) {
        	header('../trans/home');exit;
        }
        $this->load->model('trans/trans_model');
        $this->trans_model->name = $_SESSION['name'];
        $this->trans_model->id = $_SESSION['id'];
        $this->trans_model->pid = $_SESSION['pid'];
        $this->trans_model->tag = $_SESSION['tag'];
        if(!empty($_SESSION['invitation']) ){
        	$this->trans_model->invitation = $_SESSION['invitation'];
        }else {
        	$this->trans_model->invitation = '';
        }
        //总推广人数
        $resultperson = $this->trans_model->getTransUser();
        //获取总佣金数
        $resultMoney= $this->trans_model->getTransMoney();
        $count =0;
        $person=0;
        $Invitation='';
        switch ($_SESSION['tag']){
        	case '1':
        		foreach($resultMoney as $k=>$v){
        			$count +=$v['royalty_comm_sum'];
        		}
        		break;
        	case '2':
        		foreach($resultMoney as $k=>$v){
        			$count +=$v['royalty_comm_sum']*$v['trans_proportion']/100;
        		}
        		break;
        	case '3':
        		$Invitation = $this->trans_model->getTransInvitation();
        		$smarty->assign("invitation",$Invitation[0]['invitation']);
        		$smarty->assign("qrcode",$Invitation[0]['qrcode']);
        		foreach($resultMoney as $k=>$v){
        			$count +=$v['royalty_comm_sum']*$v['trans_proportion']/100*$v['promoter_proportion']/100;
        		}
        		break;
        	default: $count=0; 
        }
        $person = $resultperson['count'];
        $smarty->assign("money",round($count,2));
        $smarty->assign("person",$person);
        $smarty->assign("tag",$_SESSION['tag']);
        $smarty->display('trans/index.html');
    }
    //获取用户的总推广人数 +日期搜索
    public function userSum(){
    	//校验获取的参数
    	$data=$this->input->post();
    	$this->load->model('trans/trans_model');
    	$this->trans_model->id = $_SESSION['id'];
    	$this->trans_model->tag = $_SESSION['tag'];
		if(!empty($data['start'])){
  			$this->trans_model->starttime = $data['start']." 00:00:01";
  		}
  		if(!empty($data['end'])){
  			$this->trans_model->endtime = $data['end']." 23:59:59";
  		}
    	if(!empty($_SESSION['invitation'])){
    		$this->trans_model->invitation = $_SESSION['invitation'];
    	}
    	$resultday = $this->trans_model->getTransUser();
    	$resultday['name'] = $_SESSION['name'];
       	if ($resultday==false) {
    		currency::Output($this->config->item('request_fall'),'参数错误','','');
    	}
    	currency::Output($this->config->item('request_succ'),'','../trans/',$resultday);
    }
    //获取佣金结算列表页面
    function commList(){
    	// 校验用户是否在线
    	currency::checkOnlineCS();
    	$user=currency::getUser();//用户信息
    	if (!is_numeric($user['id']=$_SESSION['id'])) {
    		header('../trans/home');exit;
    	}
    	//校验获取参数
    	$data=$this->input->post();
    	foreach ($data as $k=>$v){
    		if(strlen($v)<0){
    			currency::Output($this->config->item('request_fall'),'没有获取必填参数的值');
    		}
    	}
    	//获取用户总佣金数
    	$this->load->model('trans/trans_model');
    	$this->trans_model->id = $_SESSION['id'];
    	$this->trans_model->pid = $_SESSION['pid'];
    	$this->trans_model->tag = $_SESSION['tag'];
    	$resultMoney= $this->trans_model->getTransMoney();
    	$count =0;
    	$person=0;
    	$Invitation='';
    	switch ($_SESSION['tag']){
    		case '1':
    			foreach($resultMoney as $k=>$v){
    				$count +=$v['royalty_comm_sum'];
    			}
    			break;
    		case '2':
    			foreach($resultMoney as $k=>$v){
    				$count +=$v['royalty_comm_sum']*$v['trans_proportion']/100;
    			}
    			break;
    		case '3':
    			foreach($resultMoney as $k=>$v){
    				$count +=$v['royalty_comm_sum']*$v['trans_proportion']/100*$v['promoter_proportion']/100;
    			}
    			break;
    		default: $count=0;
    	}
    	$this->trans_model->page=$data['page'];
    	$this->trans_model->num=10;
    	if(empty($data['phone'])){
    		$this->trans_model->people=$_SESSION['name'];
    		$data['tag'] = $_SESSION['tag'];
    	}else{
    		$this->trans_model->people=$data['phone'];
    	}
    	$result = $this->trans_model->selectCommList();
    	$result['money'] = round($count,2);
    	if($result==false) {
    		currency::Output($this->config->item('request_fall'),'','','没有获取到结果');
    	}
    	currency::Output($this->config->item('request_succ'),'','',$result); 
    }
    //获取寄售回收销售页面数据
  	function selectList(){
  		// 校验用户是否在线
  		currency::checkOnlineCS();
  		$user=currency::getUser();//用户信息
  		if (!is_numeric($user['id']=$_SESSION['id'])) {
  			header('../trans/home');exit;
  		}
  		//校验获取参数
  		$data=$this->input->post();
  		if(!empty($data)){
  			if(empty($data['type']) || empty($data['page'])){
				currency::Output($this->config->item('request_fall'),'没有获取必填参数的值');
			}
  		}
		$this->load->model('trans/trans_model');
		$this->trans_model->id = $_SESSION['id'];
		$this->trans_model->pid = $_SESSION['pid'];
		$this->trans_model->tag = $_SESSION['tag'];
		if(!empty($data['start'])){
  			$this->trans_model->starttime = strtotime($data['start']." 00:00:01");
  		}
  		if(!empty($data['end'])){
  			$this->trans_model->endtime = strtotime($data['end']." 23:59:59");
  		}
		if(!empty($_SESSION['invitation'])){
			$this->trans_model->invitation = $_SESSION['invitation'];
		}
    	$this->trans_model->type=$data['type'];
    	$this->trans_model->page=$data['page'];
    	$this->trans_model->num=10;
    	$result = $this->trans_model->selectData();
    	if($result==false) {
     		currency::Output($this->config->item('request_fall'),'','','没有获取到结果');
    	}
     	currency::Output($this->config->item('request_succ'),'','',$result);
  	}
  	//查询当前用户底下的所有代理
  	function agentList(){
  		// 校验用户是否在线
  		currency::checkOnlineCS();
  		$user=currency::getUser();//用户信息
  		if (!is_numeric($user['id']=$_SESSION['id'])) {
  			header('../trans/home');exit;
  		}
		//校验获取参数		
  		$data=$this->input->post();
  		if(!empty($data)){
			if(empty($data['type']) || empty($data['page'])){
				currency::Output($this->config->item('request_fall'),'没有获取必填参数的值');
			}
  		}
  		$this->load->model('trans/trans_model');
  		$this->trans_model->page=$data['page'];
  		$this->trans_model->num=10;
  		$this->trans_model->phone = $_SESSION['name'];
  		$this->trans_model->id = $_SESSION['id'];
  		$this->trans_model->tag = $_SESSION['tag'];
		if(!empty($data['start'])){
  			$this->trans_model->starttime = strtotime($data['start']." 00:00:01");
  		}
  		if(!empty($data['end'])){
  			$this->trans_model->endtime = strtotime($data['end']." 23:59:59");
  		}
  		$result = $this->trans_model->agentList();
  		$result['tag'] = $_SESSION['tag'];
  		if ($result==false) {
  			currency::Output($this->config->item('request_fall'),'未知错误','','');
  		}
  		currency::Output($this->config->item('request_succ'),'','',$result);
  	}
	//给代理或者推广员结算佣金
	function checkOut(){
		// 校验用户是否在线
		currency::checkOnlineCS();
		$user=currency::getUser();//用户信息
		if (!is_numeric($user['id']=$_SESSION['id'])) {
			header('../trans/home');exit;
		}
		//校验获取参数
		$data=$this->input->post();
		if(!empty($data)){
			foreach ($data as $k=>$v){
				if(empty($v)){
					currency::Output($this->config->item('request_fall'),'没有获取必填参数的值');
				}
			}
		}
		$this->load->model('trans/trans_model');
		$this->trans_model->sums = $data['sums'];
		$this->trans_model->money = $data['lastMoney']-$data['sums'];
		$this->trans_model->person = $_SESSION['name'];
		$this->trans_model->people = $data['name'];
		$result=$this->trans_model->checkOut();
		if ($result==false) {
			currency::Output($this->config->item('request_fall'),'未知错误','','');
		}
		currency::Output($this->config->item('request_succ'),'','',$result);
	}
}