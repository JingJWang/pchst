<?php
/**
 * 订单模块  数码订单
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class comm extends CI_Controller{
    
    function commAdd(){
        //校验用户是否在线
        $this->load->model('center/login_model');
        $this->login_model->isOnine();
        //获取参数
        $rmoney=$this->input->post('rmoney',true);
        $smoney=$this->input->post('smoney',true);
        $people=$this->input->post('people',true);
        //校验是否参数是否为空
        if(empty($rmoney) || empty($smoney)|| empty($person)|| empty($people)){
        	Universal::Output($this->config->item('request_fall'),'不能为空');
        }
        $this->load->model('trans/comm_model');
        $this->comm_model->rmoney=$rmoney;
        $this->comm_model->smoney=$smoney;
        $this->comm_model->people=$people;
        $this->comm_model->otime=time();
        $this->comm_model->person=$_SESSION['user']['mobile'];
        $response=$this->comm_model->insert();
        if($response == false){
        	Universal::Output($this->config->item('request_fall'),'没有获取到结果');
        }else{
            Universal::Output($this->config->item('request_succ'),'','',$response);
        }
    }
    //查看 列表页面
    function commList(){
    	//校验用户是否在线
    	$this->load->model('center/login_model');
    	$this->login_model->isOnine();
    	$this->load->model('trans/comm_model');
    	$this->comm_model->person=$_SESSION['user']['mobile'];
    	$this->comm_model->page=$page;
    	$this->comm_model->num=3;
    	$response=$this->settlement_model->select();
    	if($response == false){
    		Universal::Output($this->config->item('request_fall'),'没有获取到结果');
    	}else{
    		Universal::Output($this->config->item('request_succ'),'','',$response);
    	}
    }
}